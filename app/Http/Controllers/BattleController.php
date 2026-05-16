<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class BattleController extends Controller
{
    public function index(): View
    {
        return view('battle.index');
    }
}
