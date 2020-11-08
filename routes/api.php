<?php

Route::namespace('Auth')->group(function(){
    Route::post('register', 'RegisterController');
    Route::post('verification', 'VerificationController');
    Route::post('regenerate-otp', 'RegenerateController');
    Route::post('update-password', 'UpdatepasswordController');
    Route::post('login', 'LoginController');
    Route::post('logout', 'LogoutController');
});

Route::get('get-profil', 'UserController@getProfil');
Route::post('update-profil', 'UserController@updateProfil');




?>