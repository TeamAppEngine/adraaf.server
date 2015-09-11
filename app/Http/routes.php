<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::bind('uuid',function($uuid){

    $userModel = new \Repositories\UserRepository(new \App\User);
    return $userModel->getUserBasedOnUuid($uuid);

});

Route::bind('offer_id',function($id){

    $offerModel = new \Repositories\OfferRepository(new \App\Offer);
    return $offerModel->getOfferBasedOnId($id);

});

//caa126a6-b0b8-440c-8512-9c506264bf61
//Route::pattern('uuid','/\w{8}-\w{4}-\w{4}-\w{4}-\w{12}/');

//--------------------   V1  ---------------------

Route::post('api/users', 'UsersController@store');

Route::get('api/users/login_session','UsersController@getSession');

Route::get('api/users/offers','UsersController@getOffers');

Route::get('api/users/{uuid}/offers','UsersController@getOffers');

Route::get('api/users/offers','UsersController@getOffersAnonymously');

Route::post('api/users/{uuid}/share/{offer_id}','UsersController@logShare');

Route::post('api/users/{uuid}/save/{offer_id}','UsersController@logSave');

Route::post('api/users/{uuid}/buy/{offer_id}','UsersController@logBuy');

Route::get('api/stores/{id}/image','UsersController@getImage');//TODO

//--------------------- Default -------------------

Route::get('/', function () {
    return view('welcome');
});

