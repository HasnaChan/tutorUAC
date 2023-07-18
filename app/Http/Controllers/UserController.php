<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function developerIndex(){
        $games = Game::where('user_id',auth()->user()->id)->get();

        return view('developer.home', compact('games'));
    }
}
