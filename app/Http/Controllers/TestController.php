<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function user(){
        return 'User berhasil masuk';

    }

    public function verified(){
        return 'Admin berhasil masuk, dan sudah verified email';

    }
}
