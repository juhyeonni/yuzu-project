<?php

use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\GameScoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware("auth:sanctum")->get("/user", function (Request $request) {
  return $request->user();
});

Route::get("/posts/search", [PostController::class, "search"])->name("search");

// Route::post("/posts/{id}/like", [LikeController::class, "likeToggle"])->name(
//   "like"
// );

Route::delete("/posts/{id}", [PostController::class, "destroy"]);

Route::get("/score/{user_id}", [
  GameScoreController::class,
  "getScoreByUserId",
])->name("score");

Route::post("/ranking", [GameScoreController::class, "record"])->name("record");

Route::get("/ranking/{user_id}", [
  GameScoreController::class,
  "rankingByUserId",
]);
