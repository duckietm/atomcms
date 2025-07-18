<?php

namespace App\Http\Controllers;

use App\Actions\SendCurrency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BadgeController extends Controller
{
    public function show()
    {
        return view('draw-badge');
    }

    public function buy(Request $request, SendCurrency $sendCurrency)
    {
        $user = Auth::user();
        $cost = 150;

        // Check if user has enough credits (assuming credits are stored in the user model; adjust if always handled by RCON)
        if ($user->credits < $cost) {
            return response()->json(['success' => false, 'message' => 'Insufficient credits.'], 400);
        }

        // Deduct credits (negative amount to reduce)
        $result = $sendCurrency->execute($user, 'credits', -$cost);

        if ($result === false) {
            return response()->json(['success' => false, 'message' => 'Failed to deduct credits.'], 500);
        }

        // Later, add badge saving logic here

        return response()->json(['success' => true]);
    }
}