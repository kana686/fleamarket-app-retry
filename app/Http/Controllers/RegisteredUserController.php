<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request, CreatesNewUsers $creator)
    {
        $user = $creator->create($request->validated());

        auth()->login($user);

        session(['is_first_login' => true]);

        return redirect()->route('profile.edit');
    }
}
