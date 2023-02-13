<?php

use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Auth::routes();

Route::get('/', [App\Http\Controllers\FrontController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/contact',[App\Http\Controllers\FrontController::class,'contactus']);
Route::get('/features', [App\Http\Controllers\FrontController::class, 'feature']);
Route::get('/pricing', [App\Http\Controllers\FrontController::class, 'pricing']);
Route::get('/blog', [App\Http\Controllers\FrontController::class, 'blog']);
Route::get('/affiliate',[App\Http\Controllers\FrontController::class,'affiliates']);
Route::get('/privacy-policy',[App\Http\Controllers\FrontController::class,'privacy_policy']);
Route::get('/Terms&condition',[App\Http\Controllers\FrontController::class,'termscondition']);
Route::get('/test_email',[App\Http\Controllers\FrontController::class,'test_email']);
Route::get('activate_user/{id}',[App\Http\Controllers\AdminController::class,'activate_user']);
Route::get('/embed/{id?}',[App\Http\Controllers\UserController::class, 'embed']);
Route::post('/setVideoTiming',[App\Http\Controllers\TestCronJobController::class,'setVideoTiming']);
Route::post('/getCurrentVideoAndTime',[App\Http\Controllers\UserController::class,'getCurrentVideoAndTime']);
Route::post('/signInGoogle',[App\Http\Controllers\AdminController::class, 'signInGoogle']);
Route::get('/passwordForgot',[App\Http\Controllers\AdminController::class, 'passwordForgot']);
Route::post('/verifyEmailForFP',[App\Http\Controllers\AdminController::class, 'verifyEmailForFP']);
Route::get('/passwordReset',[App\Http\Controllers\AdminController::class, 'passwordReset']);
Route::post('/passwordChange',[App\Http\Controllers\AdminController::class, 'passwordChange']);
Route::get('/testCronJob', [App\Http\Controllers\TestCronJobController::class, 'testCronJob']);
Route::post('/loopChannelDynamicPlaylist', [App\Http\Controllers\UserController::class, 'loopChannelDynamicPlaylist']);
Route::post('/setNextVideoAndTimeOnVideoEnded', [App\Http\Controllers\UserController::class, 'setNextVideoAndTimeOnVideoEnded']);

Route::group(['middleware' => 'auth'], function ()
{
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index']);
    Route::get('/user/manage', [App\Http\Controllers\UserController::class, 'index']);
    //Admin UserManage
    Route::get('/manage_user', [App\Http\Controllers\AdminController::class, 'manage_users']);
    Route::post('/add_user', [App\Http\Controllers\AdminController::class, 'insert_user']);
    Route::post('/edit_user', [App\Http\Controllers\AdminController::class, 'update_user']);
    Route::get('/delete_user/{id}',[App\Http\Controllers\AdminController::class,"delete_user"])->name('admin.delete_user');
    Route::post('/get_user_by_id',[App\Http\Controllers\AdminController::class,"get_user_by_id"])->name('admin.get_user_by_id');
    Route::get('changeStatus', 'UserController@changeStatus');
    //Admin ManageChanel
    Route::get('/manage_channel', [App\Http\Controllers\AdminController::class, 'manage_channel']);
    Route::get('/delete_channel/{id}',[App\Http\Controllers\AdminController::class,"delete_chanel"])->name('admin.delete_channel');
    //Admin Managevideo
    Route::get('/admin_manage_videos',[App\Http\Controllers\AdminController::class,'admin_manage_vid']);
    //Admin Analytics
    Route::get('/admin_analytics',[App\Http\Controllers\AdminController::class,'analytics']);
    //Admin Packages
    Route::get('/package',[App\Http\Controllers\AdminController::class,'packages']);

    // Users Channel
    Route::get('profile', [App\Http\Controllers\UserController::class, 'profile']);
    Route::get('/manage/channels', [App\Http\Controllers\ChannelController::class, 'index']);
    Route::get('/create_channel', [App\Http\Controllers\ChannelController::class, 'create_channel']);
    Route::get('/linear_scheduled/{id?}', [App\Http\Controllers\ChannelController::class, 'linear_scheduled']);
    Route::get('/looped/{id?}', [App\Http\Controllers\ChannelController::class, 'linear_looped']);
    Route::post('/submit_looped_chanel', [App\Http\Controllers\ChannelController::class, 'submit_looped_chanel']);
    Route::get('/ondemand/{id?}', [App\Http\Controllers\ChannelController::class, 'ondemand']);
    Route::post('/submit_ondemand_chanel', [App\Http\Controllers\ChannelController::class, 'submit_ondemand_chanel']);
    Route::post('/submit_linear', [App\Http\Controllers\ChannelController::class, 'submit_linear_chanel']);
    Route::get('/chanel_list', [App\Http\Controllers\ChannelController::class, 'chanel_list']);
    Route::get('/delete-chanel/{id}', [App\Http\Controllers\ChannelController::class, 'delete_channel']);
    Route::get('/edit_channel', [App\Http\Controllers\ChannelController::class, 'edit_channel']);
    Route::post('/video_store', [App\Http\Controllers\ChannelController::class, 'add_video']);
    Route::get('/schedule_video',[App\Http\Controllers\ChannelController::class,'schedule_videos']);
    Route::post('/channel_detail',[App\Http\Controllers\ChannelController::class,'channel_select_detail']);
    Route::get('/channel/delete_video/{channel_id}/{video_id}',[App\Http\Controllers\ChannelController::class,'delete_video_from_channel']);
    Route::post('/channel/sortVideos',[App\Http\Controllers\ChannelController::class,'sortVideos']);
    Route::post('/createDuplicateChannel',[App\Http\Controllers\ChannelController::class,'createDuplicateChannel']);

    // Users Video
    Route::get('/manage/videos', [App\Http\Controllers\UserController::class, 'video']);
    Route::get('/select_video', [App\Http\Controllers\UserController::class, 'select_video']);
    Route::post('/insert_video', [App\Http\Controllers\UserController::class, 'insert_video']);
    Route::get('/add_watermark', [App\Http\Controllers\UserController::class, 'add_watermark']);
    Route::get('/downloads/{file}', [App\Http\Controllers\UserController::class, 'download']);
    Route::post('/edit_data', [App\Http\Controllers\UserController::class, 'edit_data']);
    Route::post('/fetch_ajax_vedio', [App\Http\Controllers\UserController::class, 'fetch_ajax_vedio'])->name('fetch_ajax_vedio');
    Route::get('/delete/vedio/{id}', [App\Http\Controllers\UserController::class, 'delete_vedio']);
    Route::get('/download/video/{id}', [App\Http\Controllers\UserController::class, 'download_video']);
    Route::post('/edit_vedio_post', [App\Http\Controllers\UserController::class, 'edit_vedio_post'])->name('edit_vedio_post');
    Route::post('/edit_data_ajax', [App\Http\Controllers\UserController::class, 'edit_data_ajax'])->name('edit_data_ajax');
    Route::post('/add_tag_ajax', [App\Http\Controllers\UserController::class, 'add_tag_ajax'])->name('add_tag_ajax');
    Route::get('/manage/videos/single/{id}',[App\Http\Controllers\UserController::class,"show_single_video"]);
    Route::post('/addM3u8Link',[App\Http\Controllers\UserController::class, 'addM3u8Link']);
    Route::post('/insert_tag', [App\Http\Controllers\UserController::class, 'insert_tag'])->name('insert_tag');
    Route::post('/search-videos_by_tag', [App\Http\Controllers\UserController::class, 'searchPosts_by_tag']);
    Route::post('/searchPosts-by-name', [App\Http\Controllers\UserController::class, 'searchPosts_by_name']);
    Route::post('/user/search_video', [App\Http\Controllers\UserController::class, 'search_video']);
    Route::get('/scheduleVideo/{id?}',[App\Http\Controllers\UserController::class, 'scheduleVideo']);
    Route::post('/ajaxScheduleVideo',[App\Http\Controllers\UserController::class, 'ajaxScheduleVideo']);
    Route::post('/setScheduleRow',[App\Http\Controllers\UserController::class, 'setScheduleRow']);
    Route::post('/getScheduleRow',[App\Http\Controllers\UserController::class, 'getScheduleRow']);
    Route::post('/getSpecificVideoScheduleTime',[App\Http\Controllers\UserController::class,'getSpecificVideoScheduleTime']);
    Route::post('/removeSpecificVideoScheduleTime',[App\Http\Controllers\UserController::class,'removeSpecificVideoScheduleTime']);
    Route::post('/previewCustomSchedule',[App\Http\Controllers\UserController::class,'previewCustomSchedule']);
    Route::post('/getScheduledVideosOfSpesificChannel',[App\Http\Controllers\UserController::class,'getScheduledVideosOfSpesificChannel']);

    Route::resource('websites', WebsiteController::class);
    Route::get('/delete/website/{id}', [App\Http\Controllers\WebsiteController::class, 'destroy']);

    Route::get('/Analytics',[App\Http\Controllers\AnalyticsController::class,'index']);
});
