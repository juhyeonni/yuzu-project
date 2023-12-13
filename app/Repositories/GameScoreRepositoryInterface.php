<?php

namespace App\Repositories;
use Illuminate\Database\Eloquent\Collection;

interface GameScoreRepositoryInterface
{
  public function scoring(int $score, int $user_id): void;

  public function getScoreByUserId(int $user_id): int;

  public function rankingList();

  public function rankingByUserId(int $user_id);
}
