<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MypageController;

// Homepage Route
Route::get('/',  function() {return redirect()->route('item_list');})->name('welcome');

// Authentication Routes

Route::get('/signup/{role?}', [RegisterController::class, 'index']);
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/loginview', [LoginController::class, 'loginview']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard Routes
Route::group(['prefix' => 'dashboard','middleware' => ['auth']], function() {
    Route::get('/',[DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    // Review template routes
    Route::resource('review_templates', ReviewTemplateController::class);
    Route::delete('review_templates/destroy', [ReviewTemplateController::class, 'destroy'])->name('delete_template');
    Route::get('/producer/{producer_id}/detail', [ProducerController::class, 'detail_view'])->name('producer_detail_view');
});

Route::group(['middleware' => ['auth']], function() {
    // Route::get('/mypage', [MypageController::class, 'index'])->name('welcome');
    Route::get('/mypage', function() {
        return redirect()->route('item_list');
    })->name('welcome');
    Route::get('/mypage/item_add', [MypageController::class, 'itemAdd'])->name('item_add');
    Route::post('/mypage/add_item', [MypageController::class, 'saveItem'])->name('save_item');
    Route::get('/mypage/item_list', [MypageController::class, 'item_list'])->name('item_list');
    Route::get('/mypage/item/{id}', [MypageController::class, 'get_item'])->name('get_item');
    Route::get('/mypage/error_list', [MypageController::class, 'error_list'])->name('error_list');
    Route::get('/mypage/item/edit/{id}', [MypageController::class, 'itemEdit']);
    Route::post('/mypage/delete_item', [MypageController::class, 'delete_item'])->name('delete_item');
    Route::get('/mypage/account_manage', [MypageController::class, 'manage_account'])->name('manage_account');
    Route::get('/mypage/delete_account', [MypageController::class, 'delete_account'])->name('delete_account');
    Route::get('/mypage/permit_account', [MypageController::class, 'permit_account'])->name('permit_account');
    Route::get('/mypage/scan', [MypageController::class, 'scanDB'])->name('scan_db');
    Route::get('/mypage/check_other_registering_status', [MypageController::class, 'checkOtherRestigerStatus'])->name('check_other_registering_status');
    Route::get('/mypage/reset_register', [MypageController::class, 'resetRegisterValues'])->name('reset_register');
    Route::get('/mypage/register_tracking', [MypageController::class, 'register_tracking'])->name('register_tracking');
    Route::get('/mypage/update_tracking', [MypageController::class, 'update_tracking'])->name('update_tracking');
    Route::get('/mypage/shop_list/{id}', [MypageController::class, 'shop_list'])->name('shop_list');
    Route::post('/mypage/get_allitems', [MypageController::class, 'get_allitems'])->name('get_allitems');
    Route::get('/mypage/edit_track', [MypageController::class, 'edit_track'])->name('edit_track');
    Route::get('/mypage/search', [MypageController::class, 'search'])->name('search');
    Route::get('/mypage/individual', [MypageController::class, 'regTrack'])->name('reg');
    Route::get('/mypage/change_percent', [MypageController::class, 'change_percent'])->name('change_percent');
    Route::get('/mypage/set_registering_state', [MypageController::class, 'set_state'])->name('set_state');
    Route::get('/mypage/get_registering_state', [MypageController::class, 'get_state'])->name('get_state');
    Route::get('/mypage/save_name_index', [MypageController::class, 'save_name_index'])->name('save_name_index');

    // send a alert message to the client with eamil
    // Route::get('/mypage/update_alert', [MypageController::class, 'updateAlert'])->name('alert');
    
    // register yahoo token
    Route::post('/mypage/register_token', [MypageController::class, 'register_token'])->name('register_token');
    
    //download zip file
    Route::get('/mypage/ext_download', [MypageController::class, 'extDownload'])->name('extDownload');
});

Route::get('forgot-password', [LoginController::class, 'forgotPwd'])->name('forgot');
Route::get('reset_password', [LoginController::class, 'resetPwd'])->name('reset');
Route::get('reset_pwd', function() { return view('auth.reset'); });
Route::post('update_password', [LoginController::class, 'updatePwd'])->name('password.update');