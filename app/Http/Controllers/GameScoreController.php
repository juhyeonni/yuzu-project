<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Eloquent\GameScoreRepository;

class GameScoreController extends Controller
{
  public function __construct(
    protected GameScoreRepository $gameScoreRepository
  ) {
  }

  public function record(Request $request): \Illuminate\Http\JsonResponse
  {
    $score = $request->input("score");
    $user_id = $request->input("user_id");

    $this->gameScoreRepository->scoring($score, $user_id);

    return response()->json([
      "message" => "success",
    ]);
  }

  public function getScoreByUserId(int $user_id): \Illuminate\Http\JsonResponse
  {
    $score = $this->gameScoreRepository->getScoreByUserId($user_id);

    return response()->json([
      "message" => "success",
      "score" => $score,
    ]);
  }

  public function ranking()
  {
    $userId = auth()->id();

    $rankingList = $this->gameScoreRepository->rankingList();
    $nearRankingList = $userId
      ? $this->gameScoreRepository->nearRankingList($userId)
      : [];

    return view("(ranking).list", [
      "rankingList" => $rankingList,
      "nearRankingList" => $nearRankingList,
    ]);
  }

  public function rankingByUserId(int $user_id)
  {
    $ranking = $this->gameScoreRepository->rankingByUserId($user_id);

    return $ranking;
  }
}
