<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GameController extends Controller
{
    public function create(){
        return view('developer.add-game');
    }

    public function store(Request $request){
        $validate = $request->validate([
            'name' => 'required',
            'description' => 'required|min:10',
            'price' => 'required',
            'image' => 'required|image|file|max:2048'
        ]);

        $validate['image'] = $request->file('image')->store('games');
        $validate['user_id'] = auth()->user()->id;

        Game::create($validate);

        return redirect('developer');
    }

    public function edit($game_id){
        $game = Game::findOrFail($game_id);

        return view('developer.edit-game', compact('game'));
    }

    public function update(Request $request){
        $validate = $request->validate([
            'name' => 'required',
            'description' => 'required|min:10',
            'price' => 'required',
            'image' => 'image|file|max:2048'
        ]);

        if($request->file('image')){
            if($request->oldImage){
                Storage::delete(($request->oldImage));
            }
            $validate['image'] = $request->file('image')->store('games');
        }

        $validate['user_id'] = auth()->user()->id;

        Game::find($request->game_id)->update($validate);

        return redirect('/developer');
    }
}

