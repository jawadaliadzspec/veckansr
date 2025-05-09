<?php

use App\Http\Controllers\User\CouponController;
use App\Lib\Router;
use Illuminate\Support\Facades\Route;

Route::get('/clear', function(){
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});
Route::controller('ScraperController')->group(function () {
    Route::get('/scrapeTop20', 'scrapeTop20')->name('scrapeTop20');
    Route::get('/getApplications', 'getApplications')->name('getApplications');
    Route::get('/getProductFeed', 'getProductFeed')->name('getProductFeed');
});
// User Support Ticket
Route::controller('TicketController')->prefix('ticket')->group(function () {
    Route::get('/', 'supportTicket')->name('ticket');
    Route::get('/new', 'openSupportTicket')->name('ticket.open');
    Route::post('/create', 'storeSupportTicket')->name('ticket.store');
    Route::get('/view/{ticket}', 'viewTicket')->name('ticket.view');
    Route::post('/reply/{ticket}', 'replyTicket')->name('ticket.reply');
    Route::post('/close/{ticket}', 'closeTicket')->name('ticket.close');
    Route::get('/download/{ticket}', 'ticketDownload')->name('ticket.download');
});



Route::controller('SiteController')->group(function () {
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contactSubmit');
    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');

    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');

    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');

    // blog
    Route::get('/blog', 'blog')->name('blog');;
    Route::get('blog/{slug}/{id}', 'blogDetails')->name('blog.details');

    Route::get('policy/{slug}/{id}', 'policyPages')->name('policy.pages');

    Route::get('placeholder-image/{size}', 'placeholderImage')->name('placeholder.image');
    Route::get('get/modal/info','getModalInfo')->name('get.modal.info');
    Route::get('/categories', 'categories')->name('categories');

    // exclusive coupon
    Route::get('/exclusive-coupons', 'exclusiveCoupon')->name('exclusive.coupons');
    Route::get('/coupons', 'coupons')->name('coupon');
//    Route::get('/deal/{deal}', 'couponDetails')->name('couponDetails');
    Route::get('/{deal}', 'couponDetails')->name('couponDetails');

    // category

    Route::get('/category/coupons/{id}', 'categoryCoupons')->name('category.coupons');
    Route::get('/store/coupons/{id}', 'storeCoupons')->name('store.coupons');

    // feature coupon
    Route::get('/feature-coupons', 'featureCoupon')->name('feature.coupons');

    // feature store
    Route::get('/feature-store', 'featureStore')->name('feature.store');

    // coupon filter
    Route::get('exclusive/coupon/filter', 'exclusiveCouponFilter')->name('exclusive.coupon.filtered');
    Route::get('/feature/coupon/filter', 'featureCouponFilter')->name('feature.coupon.filtered');
    Route::get('coupon/filter', 'couponFilter')->name('coupon.filtered');

    //Single coupon Search
    Route::get('coupon/search', 'singleCouponSearch')->name('single.coupon.search');

    // subscriber
    Route::post('/subscribe','subscribe')->name('subscribe');

    Route::get('/{slug}', 'pages')->name('pages');
//    Route::get('/{deal}', 'couponDetails')->name('couponDetails');
    Route::get('/', 'index')->name('home');

});

//Route::get('/{deal}', [\App\Http\Controllers\SiteController::class, 'couponDetails'])->where('deal', '[a-zA-Z0-9-_]+')->name('couponDetails');



