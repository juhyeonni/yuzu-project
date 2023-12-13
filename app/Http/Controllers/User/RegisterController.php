<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
  public function index() {
    return view('(auth).register');
  }

  public function store(StoreRegisterRequest $request) {
    $validated = $request->validated();

    $user = User::create([
      'name' => $validated['name'],
      'email' => $validated['email'],
      'password' => bcrypt($validated['password']),
    ]);

    Auth::login($user);

    return redirect()->route('status');
  }
}
