<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BadgeController extends Controller
{
    public function show()
    {
        return view('draw-badge');
    }
}