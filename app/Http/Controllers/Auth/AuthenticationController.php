<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
   public function register(){
    return response([
        'message' => 'api working'
       ]);
   }
}
