<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Page;
use App\Models\Store;
use App\Models\Coupon;
use App\Models\Category;
use App\Models\Frontend;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\Subscriber;
use App\Models\SupportMessage;
use App\Models\AdminNotification;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;

class SiteController extends Controller
{
    public function index(){
        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }
        if (empty($reference)) {
            session()->forget('reference');
        }

        $pageTitle = 'Home';
        $sections = Page::where('tempname',$this->activeTemplate)->where('slug','/')->first();
        $categories =  Category::where('status',1)->latest()->limit(4)->get();
        return view($this->activeTemplate . 'home', compact('pageTitle','sections','categories'));
    }

    public function pages($slug)
    {
        $page = Page::where('tempname',$this->activeTemplate)->where('slug',$slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle','sections'));
    }


    public function contact()
    {
        $pageTitle = "Contact Us";
        return view($this->activeTemplate . 'contact',compact('pageTitle'));
    }


    public function contactSubmit(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        if(!verifyCaptcha()){
            $notify[] = ['error','Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $request->session()->regenerateToken();

        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = 2;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view',$ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'Ticket created successfully!'];

        return to_route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function policyPages($slug,$id)
    {
        $policy = Frontend::where('id',$id)->where('data_keys','policy_pages.element')->firstOrFail();
        $pageTitle = $policy->data_values->title;
        return view($this->activeTemplate.'policy',compact('policy','pageTitle'));
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return back();
    }

    public function blog(){
        $pageTitle = 'Blog';
        $sections = Page::where('tempname',$this->activeTemplate)->where('slug','blog')->firstOrFail();
        $blogs = Frontend::where('data_keys','blog.element')->orderBy('id','desc')->paginate(getPaginate());

        return view($this->activeTemplate.'blog',compact('sections','blogs','pageTitle'));
    }

    public function blogDetails($slug,$id){
        $blog = Frontend::where('id',$id)->where('data_keys','blog.element')->firstOrFail();
        $pageTitle = "Blog Details";
        $latests = Frontend::where('data_keys','blog.element')->orderBy('id','desc')->limit(5)->get();
        return view($this->activeTemplate.'blog_details',compact('blog','pageTitle','latests'));
    }

    public function cookieAccept(){
        $general = gs();
        Cookie::queue('gdpr_cookie',$general->site_name , 43200);
        return back();
    }

    public function cookiePolicy(){
        $pageTitle = 'Cookie Policy';
        $cookie = Frontend::where('data_keys','cookie.data')->first();
        return view($this->activeTemplate.'cookie',compact('pageTitle','cookie'));
    }

    public function placeholderImage($size = null){
        $imgWidth = explode('x',$size)[0];
        $imgHeight = explode('x',$size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if($imgHeight < 100 && $fontSize > 30){
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 255, 255, 255);
        $bgFill    = imagecolorallocate($image, 28, 35, 47);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    public function getModalInfo(Request $request){
        $couponId =  $request->couponId;
        $coupon = Coupon::with('store')->where('id',$couponId)->first();
        $image = $coupon->store->image;
        $isUrl = filter_var($image, FILTER_VALIDATE_URL);
        $storeImage = $isUrl ? $image : getFilePath('store') . '/' . $coupon->store->image;
        $storeName = $coupon->store->name;

        return response()->json([
            'storeImage' => $storeImage,
            'storeName' => $storeName,
        ], 200);

    }

    // Exclusive Coupon
    public function exclusiveCoupon()
    {
        $pageTitle = "Exclusive Coupon";
        $exclusiveCoupons = Coupon::with(['category', 'store', 'wishlists'])->where('status', 1)->where('is_exclusive', 1)->latest()->paginate(getPaginate());
        $categories = Category::where('status', 1)->latest()->get();
        $stores = Store::where('status', 1)->latest()->get();
        return view($this->activeTemplate . 'exclusive_coupons',compact('pageTitle', 'exclusiveCoupons', 'categories', 'stores'));
    }
    // coupons
    public function coupons() {
        $pageTitle = "Coupons";
        $coupons = Coupon::with(['category', 'store','wishlists'])->where('status', 1)->latest()->paginate(getPaginate());
        $categories = Category::where('status', 1)->latest()->get();
        $stores = Store::where('status', 1)->latest()->get();
        return  view($this->activeTemplate . 'coupons',compact('pageTitle', 'coupons', 'categories', 'stores'));
    }
    public function couponDetails($slug) {
        $pageTitle = "Coupon Details";
        $coupon = Coupon::with(['category', 'store','wishlists'])->where('path',$slug)->where('status', 1)->first();
        if (!$coupon) {
            return redirect('/');
        }
//        $categories = Category::where('status', 1)->latest()->get();
//        $stores = Store::where('status', 1)->latest()->get();
        return  view($this->activeTemplate . 'coupon_details',compact('pageTitle', 'coupon'));
    }
    // categories
    public function categories() {
        $pageTitle = "categories";
        $categories = Category::query()->where('status', 1)->latest()->paginate(getPaginate());
//        $stores = Store::where('status', 1)->latest()->paginate(getPaginate(6));
        return  view($this->activeTemplate . 'categories',compact('pageTitle', 'categories'));
    }

    //feature coupon
    public function featureCoupon()
    {
        $pageTitle = "Feature Coupon";
        $featureCoupons = Coupon::with(['category', 'store','wishlists'])->where('status', 1)->where('is_featured', 1)->latest()->paginate(getPaginate());
        $categories = Category::where('status', 1)->latest()->get();
        $stores = Store::where('status', 1)->latest()->get();

        return view($this->activeTemplate . 'feature_coupons',compact('pageTitle', 'featureCoupons', 'categories', 'stores'));
    }

    //feature store
    public function featureStore()
    {
        $pageTitle = "Feature Store";
        $featureStore = Store::active()->latest()->paginate(getPaginate(8));

        return view($this->activeTemplate . 'feature_store',compact('pageTitle', 'featureStore'));
    }

    // exclusive coupon filter
    public function exclusiveCouponFilter(Request $request) {

        $categories = $request->input('categories', []);
        $stores = $request->input('stores', []);
        $search = $request->input('search');


        $query = Coupon::with(['category', 'store','wishlists'])->where('status', 1)->where('is_exclusive', 1);

        if (!empty($categories)) {
            $query->whereIn('category_id', $categories);
        }

        if (!empty($stores)) {
            $query->whereIn('store_id', $stores);
        }
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%$search%");
            });
        }

        $exclusiveCoupons = $query->get();
        $view = View::make($this->activeTemplate.'couponFilter.exclusive_coupon_search', compact('exclusiveCoupons', 'categories', 'stores'))->render();

        return response()->json([
            'html' => $view
        ]);
    }

    // feature coupon filter
    public function featureCouponFilter(Request $request) {

        $categories = $request->input('categories', []);
        $stores = $request->input('stores', []);
        $search = $request->input('search');



        $query = Coupon::with(['category', 'store','wishlists'])->where('status', 1)->where('is_featured', 1);

        if (!empty($categories)) {
            $query->whereIn('category_id', $categories);
        }

        if (!empty($stores)) {
            $query->whereIn('store_id', $stores);
        }
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%$search%");
            });
        }

        $featureCoupons = $query->get();
        $view = View::make($this->activeTemplate.'couponFilter.feature_coupon_search', compact('featureCoupons', 'categories', 'stores'))->render();

        return response()->json([
            'html' => $view
        ]);
    }

    // coupon filter
    public function couponFilter(Request $request) {

        $categories = $request->input('categories', []);
        $stores = $request->input('stores', []);
        $search = $request->input('search');

        $query = Coupon::with(['category', 'store','wishlists'])->where('status', 1);

        if (!empty($categories)) {
            $query->whereIn('category_id', $categories);
        }

        if (!empty($stores)) {
            $query->whereIn('store_id', $stores);
        }
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%$search%");
            });
        }

        $coupons = $query->get();
        $view = View::make($this->activeTemplate.'couponFilter.coupon_search', compact('coupons', 'categories', 'stores'))->render();

        return response()->json([
            'html' => $view
        ]);
    }

    //
    public function categoryCoupons($id) {
        $category = Category::find($id);
        $pageTitle =  $category->name;
        $coupons = Coupon::with(['category', 'store','wishlists'])->where('status', 1)->where('category_id', $id)->latest()->paginate(getPaginate());
        $categories = Category::where('status', 1)->latest()->get();
        $stores = Store::where('status', 1)->latest()->get();

        return  view($this->activeTemplate . 'coupons',compact('pageTitle', 'coupons', 'categories', 'stores'));

    }

        //
        public function storeCoupons($id) {
            $store = Store::find($id);
            $pageTitle =  $store->name;
            $coupons = Coupon::with(['category', 'store','wishlists'])->where('status', 1)->where('store_id', $id)->latest()->paginate(getPaginate());
            $categories = Category::where('status', 1)->latest()->get();
            $stores = Store::where('status', 1)->latest()->get();

            return  view($this->activeTemplate . 'coupons',compact('pageTitle', 'coupons', 'categories', 'stores'));

        }

        public function singleCouponSearch(Request $request) {
            $pageTitle = "Search Coupon";
            $search =$request->search;
            if(empty( $search)) {
                $notify[] = ['error','Invalid Search value'];
                return back()->withNotify($notify);
            }
            $query = Coupon::with(['category', 'store','wishlists'])->where('status', 1);
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'LIKE', "%$search%");
                });
            }
            $coupons = $query->paginate(getPaginate());
            $categories = Category::where('status', 1)->latest()->get();
            $stores = Store::where('status', 1)->latest()->get();
            return  view($this->activeTemplate . 'coupons',compact('pageTitle', 'coupons', 'categories', 'stores'));
        }

        public function subscribe(Request $request){
            $request->validate([
                'email'=>'required|unique:subscribers|email',
            ]);
            $subscribe=new Subscriber();
            $subscribe->email=$request->email;
            $subscribe->save();
            $notify[] = ['success','You have successfully subscribed to the Newsletter'];
            return back()->withNotify($notify);
        }

        public function landingPage(){
            $pageTitle = 'Landing Page';
            return view('landing',compact('pageTitle'));
        }






}
