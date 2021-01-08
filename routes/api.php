<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//TODO refactor that. Prolly separate to different files and apply middleware manually
Route::middleware(['auth:api', 'blocked'])->group(static function () {
    Route::post('refresh-token', 'Auth\TokenController@refresh');

    Route::post('verify-code', 'Verification\SmsController@verifyCode');

    Route::prefix('users')->group(static function () {
        Route::post('profile-picture', 'User\ProfilePictureController@create');
        Route::get('full-info/{id}', 'User\UserController@fullInfo');
        Route::get('{id}/adverts', 'User\UserController@getAdverts');
        Route::get('{id}/advert-requests', 'User\UserController@getAdvertRequests');
    });

    Route::resource('users', 'User\UserController');


    Route::prefix('favourites')->group(static function () {
        Route::post('add/{id}', 'Favourite\FavouriteController@favouriteAdvert');
        Route::delete('remove/{id}', 'Favourite\FavouriteController@unFavouriteAdvert');
        Route::get('users-favourites', 'Favourite\FavouriteController@userFavourites');
        Route::get('users-added-favourite/{id}', 'Favourite\FavouriteController@usersAddFavourite');
    });

    Route::prefix('advert-requests')->group(static function () {
        Route::get('personal', 'AdvertRequest\AdvertRequestController@personal');
        Route::get('', 'AdvertRequest\AdvertRequestController@index');
        Route::delete('{id}', 'AdvertRequest\AdvertRequestController@destroy');
        Route::get('{id}', 'AdvertRequest\AdvertRequestController@show');
        Route::post('', 'AdvertRequest\AdvertRequestController@store');
        Route::put('{id}', 'AdvertRequest\AdvertRequestController@update');
    });

    Route::prefix('appointments')->group(static function () {
        Route::post('attach/{id}', 'Appointment\AppointmentController@attach');
        Route::post('detach/{id}', 'Appointment\AppointmentController@detach');
        Route::get('by-user', 'Appointment\AppointmentController@usersAppointments');
        Route::get('by-advert/{id}', 'Appointment\AppointmentController@advertsAppointments');
        Route::put('{id}', 'Appointment\AppointmentController@update');
    });

    Route::prefix('advert-request-suggests')->group(static function () {
        Route::post('attach', 'AdvertRequestAdvert\AdvertRequestAdvertController@attach');
        Route::post('detach', 'AdvertRequestAdvert\AdvertRequestAdvertController@detach');
    });

    Route::post('recover-pwd', 'Auth\PasswordResetController@recoverPassword');
    Route::post('reset-pwd', 'Auth\PasswordResetController@resetPassword');
    Route::post('reset-pwd-admin/{id}', 'Auth\PasswordResetController@resetPasswordAdmin');


    Route::prefix('reviews')->group(static function () {
        Route::get('', 'UserReview\UserReviewController@index');
        Route::post('', 'UserReview\UserReviewController@create');
        Route::delete('{id}', 'UserReview\UserReviewController@destroy');
    });

    Route::prefix('messages')->group(static function () {
        Route::get('history', 'Message\MessageController@index');
        Route::get('users-chats', 'Message\MessageController@usersChats');
        Route::get('users-unread', 'Message\MessageController@usersUnread');
        Route::put('update-viewed/{id}', 'Message\MessageController@updateViewed');
    });

});

Route::post('send-code', 'Verification\SmsController@sendCode');
Route::post('confirm-pwd-reset', 'Auth\PasswordResetController@preAuthorize');

Route::prefix('advert-request-suggests')->group(static function () {
    Route::get('by-advert/{id}', 'AdvertRequestAdvert\AdvertRequestAdvertController@advertsAdvertRequests');
    Route::get('by-advert-request/{id}', 'AdvertRequestAdvert\AdvertRequestAdvertController@advertRequestsAdverts');
});

Route::prefix('advert-requests')->group(static function () {
    Route::post('search', 'AdvertRequest\AdvertRequestController@search');
});

Route::prefix('documents')->group(function () {
    Route::get('{id}', 'Document\DocumentController@show');
    Route::post('create', 'Document\DocumentController@store');
    Route::get('advert/{id}', 'Document\DocumentController@byAdvert');
    Route::delete('{id}', 'Document\DocumentController@destroy');
});

Route::prefix('address')->group(function () {
    Route::get('city/{city}/street', 'Address\AddressController@cityStreet');
    Route::get('cities', 'Address\AddressController@cities');
    Route::get('regions', 'Address\AddressController@regions');
});

Route::prefix('adverts')->group(function () {
    Route::get('personal', 'Advert\AdvertController@personal');
    Route::post('by-ids', 'Advert\AdvertController@byIds');
    Route::get('', 'Advert\AdvertController@index');
    Route::post('', 'Advert\AdvertController@store');
    Route::get('{id}', 'Advert\AdvertController@show');
    Route::post('search', 'Advert\AdvertController@search');
    Route::delete('{id}', 'Advert\AdvertController@destroy');
    Route::put('{id}', 'Advert\AdvertController@update');
});

Route::prefix('web-view')->group(function () {
    Route::get('user-info', 'User\WebViewController@getUserInfo');
});

Route::middleware(['jwtAuth'])->prefix('notifications')->group(static function() {
    Route::post('send', 'Notification\NotificationController@send');
});

require base_path('routes/auth.php');
