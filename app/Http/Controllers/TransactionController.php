<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    public function store(Request $request){

        if(Transaction::where('user_id', $request->user_id)->where('game_id', $request->game_id)->first()){
            return redirect()->back()->with("error", "You already have this game");
        }

        $transaction = new Transaction();
        $transaction->game_id = $request->game_id;
        $transaction->user_id = $request->user_id;
        $transaction->save();

        $user = User::find(auth()->user()->id);
        $user->walet = $user->wallet - $request->wallet;

        return redirect('/buyer');
    }
}
