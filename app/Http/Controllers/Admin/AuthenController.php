<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthenController extends Controller
{
    public function login()
    {
        return view('back-end.auth.login');
    }
}
