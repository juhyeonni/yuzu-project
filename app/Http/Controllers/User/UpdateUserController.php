<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Repositories\Eloquent\AvatarUploadRepository;
use Hash;
use Illuminate\Support\Facades\Auth;

class UpdateUserController extends Controller
{
  public function __construct(
    protected AvatarUploadRepository $avatarUploadRepository
  ) {
  }

  public function index()
  {
    return view("(auth).updateuser");
  }

  public function update(UpdateUserRequest $request)
  {
    $validated = $request->validated();

    try {
      $user = User::find(Auth::id());

      if (!Hash::check($validated["password"], $user->password)) {
        return redirect()
          ->route("user_update_form")
          ->withErrors(["password" => "password is not correct"]);
      }

      $user->name = $validated["name"];
      $user->email = $validated["email"];
      $user->username = $validated["username"];
      if ($request->hasFile("photo")) {
        $avatar = $this->avatarUploadRepository->uploadImage(
          $validated["photo"],
          $user->id
        );
        $user->photo = $avatar;
      }
      if (isset($validated["new_password"]) && $validated["new_password"]) {
        $user->password = bcrypt($validated["new_password"]);
      }
      $user->save();

      Auth::login($user);
    } catch (\Exception $e) {
      // dd($e);
      return redirect()
        ->route("user_update_form")
        ->withErrors([$e->getMessage()]);
    }

    return redirect()->route("status");
  }
}
