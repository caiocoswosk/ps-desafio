<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class SessionController extends Controller
{
    public function toggle()
    {
        if (session()->has('theme')) {
            session()->forget('theme');
        } else {
            session()->put('theme', 'light_mode');
        }
    }
}
