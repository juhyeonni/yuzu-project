<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GameScoreController;
use App\Http\Controllers\User\RegisterController;
use App\Http\Controllers\User\UpdateUserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/", function () {
  return view("home");
})->name("home");

// AUTHENTICATION ROUTES
Route::get("/login", [LoginController::class, "index"])->name("form_login");

Route::post("/login", [LoginController::class, "authenticate"])->name("login");

Route::get("/logout", [LogoutController::class, "index"])->name("logout");

Route::get("/register", [RegisterController::class, "index"])->name(
  "form_register"
);

Route::post("/register", [RegisterController::class, "store"])->name(
  "register"
);
/************************************************/

Route::middleware(["auth", "auth.session"])->group(function () {
  Route::get("/status", function () {
    return view("status");
  })->name("status");

  Route::get("/updateuser", [UpdateUserController::class, "index"])->name(
    "user_update_form"
  );

  Route::patch("/updateuser", [UpdateUserController::class, "update"])->name(
    "user_update"
  );
});

Route::get("/posts", [PostController::class, "index"])->name("posts");

Route::get("/posts/{id}", [PostController::class, "show"])->name(
  "posts_detail"
);

Route::get("/post", [PostController::class, "create"])->name("post_write");

Route::post("/post", [PostController::class, "store"])->name("post_store");

Route::get("/posts/{id}/edit", [PostController::class, "edit"])->name(
  "post_edit"
);

Route::put("/posts/{id}/edit", [PostController::class, "update"])->name(
  "post_update"
);

Route::delete("/posts/{id}", [PostController::class, "destroy"])->name(
  "delete"
);

Route::post("/posts/{id}/like", [PostController::class, "likeToggle"])->name(
  "post_like"
);

Route::post("/posts/{id}/comment", [CommentController::class, "store"])->name(
  "comment_store"
);

Route::delete("/comments/{id}", [CommentController::class, "destroy"])->name(
  "comment_delete"
);

Route::get("/profile/{username}", [UserController::class, "show"])->name(
  "profile"
);

Route::get("/ranking", [GameScoreController::class, "ranking"])->name(
  "ranking"
);
