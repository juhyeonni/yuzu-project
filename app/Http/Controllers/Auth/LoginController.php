<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
  public function index()
  {
    return view("(auth).login");
  }

  public function authenticate(Request $request)
  {
    $credentials = $request->only("email", "password");

    if (!Auth::attempt($credentials)) {
      return back()->withErrors([
        "email" => "The provided credentials do not match our records.",
      ]);
    }

    $request->session()->regenerate();

    return redirect()->intended();
  }
}
