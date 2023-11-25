<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NavigationController
{
    public function index(Request $request)
    {
        return $request->user()->navigations;
    }
}
