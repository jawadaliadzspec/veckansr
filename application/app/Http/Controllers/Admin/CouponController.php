<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Store;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index() {
        $pageTitle = 'Coupons List';
        $coupons = Coupon::with(['category', 'store'])->latest()->paginate(getPaginate(10));
        return view('admin.coupon.index', compact('pageTitle', 'coupons'));
    }
    public function create() {
        $pageTitle = 'Coupon Create';
        $categories = Category::with('children')->where('status', 1)->whereNull('parent_id')->get();
        $stores = Store::where('status', 1)->get();
        return view('admin.coupon.create', compact('pageTitle','categories', 'stores'));
    }
    public function store(Request $request) {
        $request->validate(
            [
                'title' =>'required',
                'category_id' =>'required',
                'store_id' =>'required',
//                'code' =>'required',
//                'start_date' =>'required',
//                'expire_date' =>'required',
//                'link' =>'required',
            ]);

            $coupon = new Coupon();
            $coupon->title=$request->title;
            $coupon->category_id=$request->category_id;
            $coupon->store_id=$request->store_id;
            $coupon->code=$request->code;
            $coupon->start_date=$request->start_date;
            $coupon->expire_date=$request->expire_date;
            $coupon->link=$request->link;
            $coupon->path=$request->path;
            $coupon->is_featured=$request->is_featured ? 1 : 0;
            $coupon->is_exclusive=$request->is_exclusive ? 1 : 0;
            $coupon->is_deal=$request->is_deal ? 1 : 0;
            $coupon->status=1;
            $coupon->description=$request->description;

        if ($request->hasFile('image')) {
            try {
                $coupon->thumnail = fileUploader($request->image, getFilePath('category'), getFileSize('category'));
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }
            $coupon->save();

            $notify[] = ['success','Coupon has been created successfully'];
            return back()->withNotify($notify);
    }

    public function edit($id) {
        $pageTitle = "Update";
        $coupon = Coupon::findOrFail($id);
        $categories = Category::with('children')->where('status', 1)->whereNull('parent_id')->get();
        $stores = Store::where('status', 1)->get();
        return view('admin.coupon.edit', compact('pageTitle','coupon','categories','stores'));
    }
    public function update(Request $request, $id) {
        $request->validate(
            [
                'title' =>'required',
                'category_id' =>'required',
                'store_id' =>'required',
//                'code' =>'required',
//                'start_date' =>'required',
//                'expire_date' =>'required',
//                'link' =>'required',
            ]);


            $coupon = Coupon::findOrFail($id);

            $coupon->title=$request->title;
            $coupon->category_id=$request->category_id;
            $coupon->store_id=$request->store_id;
            $coupon->code=$request->code;
            $coupon->start_date=$request->start_date;
            $coupon->expire_date=$request->expire_date;
            $coupon->link=$request->link;
            $coupon->path=$request->path;
            $coupon->is_featured=$request->is_featured ? 1 : 0;
            $coupon->is_exclusive=$request->is_exclusive ? 1 : 0;
            $coupon->is_deal=$request->is_deal ? 1 : 0;
            $coupon->status=$request->status ? 1: 0;
            $coupon->description=$request->description;
        if ($request->hasFile('image')) {
            try {
                $old = $coupon->image;
                $coupon->image = fileUploader($request->image, getFilePath('category'), getFileSize('category'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }
            $coupon->save();

            $notify[] = ['success','Coupon has been updated successfully'];
            // return back()->withNotify($notify);
            return to_route('admin.coupon.index')->withNotify($notify);
    }

    public function delete(Request $request) {
        $coupon = Coupon::findOrFail($request->id);
        $filePath  =  getFilePath('category') . '/' . $coupon->image;
        fileManager()->removeFile($filePath);
        $coupon->delete();

        $notify[] = ['success','Coupon has been deleted successfully'];
        return back()->withNotify($notify);

    }


    public function pending(){
        $pageTitle = "Pending Coupons";
        $coupons = Coupon::with(['category'])->where('status',0)->with('store')->orderBy('created_at','desc')->paginate(getPaginate());
        return view('admin.coupon.index',compact('pageTitle','coupons'));
    }

    public function approved(){
        $pageTitle = "Approved Coupons";
        $coupons = Coupon::with(['category'])->where('status',1)->with('store')->orderBy('created_at','desc')->paginate(getPaginate());
        return view('admin.coupon.index',compact('pageTitle','coupons'));
    }

    public function changeStatus(Request $request)  {
        $coupon =  Coupon::findOrFail($request->id);
        $coupon->status = $request->status;
        $coupon->save();
        $notify[] = ['success', 'Product reject successfully.'];
        return back()->withNotify($notify);
    }

}
