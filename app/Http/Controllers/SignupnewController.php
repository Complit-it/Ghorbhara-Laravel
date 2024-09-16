<?php

namespace App\Http\Controllers;
use App\Http\Requests\RegisterRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


class SignupnewController extends Controller
{
    public function register(RegisterRequest $request){
        $request->validated();


       $userData = [
        'name' => $request->input('name'),
        'email' => $request->email,
        'password' => $request->password
       ];

       dd($userData);
       }
}

