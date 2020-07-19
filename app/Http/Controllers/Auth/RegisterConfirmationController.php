<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;

class RegisterConfirmationController extends Controller
{
    public function index()
    {
        try {
            User::where('confirmation_token', request('token'))
                ->firstOrFail()
                ->confirm();
        } catch (\Exception $e) {
            return redirect(route('threads'))
                ->with('flash', 'Unkown token.');
        }

        return redirect(route('threads'))
            ->with('flash', 'Your account is now confirmed! You may post to the FORUM:)');
    }
}