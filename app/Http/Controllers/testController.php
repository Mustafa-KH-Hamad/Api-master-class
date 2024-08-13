<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;


class testController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
    public function show()
    {
        return view('about');
    }
}
