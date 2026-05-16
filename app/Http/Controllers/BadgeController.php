<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class BadgeController extends Controller
{
    public function index(): View
    {
        return view('badges.index');
    }
}
