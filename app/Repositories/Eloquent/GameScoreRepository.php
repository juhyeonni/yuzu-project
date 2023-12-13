<?php

namespace App\Repositories\Eloquent;
use App\Repositories\GameScoreRepositoryInterface;
use App\Models\GameScore;
use Illuminate\Support\Facades\DB;

/*
  여기서 DB::select()를 사용하는 이유는

  SELECT *, RANK() OVER (ORDER BY score DESC) as rank
  eloquent는 이런 쿼리를 날릴 수 없기 때문이다. (rank() 함수를 사용할 수 없다.)

  eloquent를 사용하면서 rank() 함수를 사용하려면
  DB::select()를 사용하는 게 가장 좋다.

  eloquent의 자체 기능으로 어떻게든 구현은 할 수 있지만,
  그렇게 하면 코드가 복잡해지고, 가독성이 떨어진다. 
  그리고 무엇보다 성능이 떨어진다.

  그래서 DB::select()를 사용했다.
*/

class GameScoreRepository extends BaseRepository implements
  GameScoreRepositoryInterface
{
  public function __construct(GameScore $model)
  {
    parent::__construct($model);
  }

  public function scoring(int $score, int $user_id): void
  {
    $this->model->where("user_id", $user_id)->delete();

    $this->model->create([
      "user_id" => $user_id,
      "score" => $score,
    ]);
  }

  public function getScoreByUserId(int $user_id): int
  {
    $score = $this->model->where("user_id", $user_id)->first();

    return $score ? $score->score : 0;
  }

  public function rankingList(): \Illuminate\Support\Collection
  {
    $query = "
        SELECT 
            users.id,
            users.username, 
            users.photo,
            game_scores.score,
            RANK() OVER (ORDER BY game_scores.score DESC) as rank
        FROM game_scores
        JOIN users ON game_scores.user_id = users.id
        ORDER BY game_scores.score DESC
        LIMIT 10
    ";

    return collect(DB::select($query));
  }

  public function nearRankingList(int $userId): \Illuminate\Support\Collection
  {
    $query = "
        WITH ranked_users AS (
            SELECT 
                users.id,
                users.username, 
                users.photo,
                game_scores.score,
                RANK() OVER (ORDER BY game_scores.score DESC) as rank
            FROM game_scores
            JOIN users ON game_scores.user_id = users.id
        ),
        user_rank AS (
            SELECT rank
            FROM ranked_users
            WHERE id = :userId
        )
        SELECT *
        FROM ranked_users
        WHERE rank BETWEEN (SELECT rank FROM user_rank) - 2 AND (SELECT rank FROM user_rank) + 2
    ";

    return collect(DB::select($query, ["userId" => $userId]));
  }

  public function rankingByUserId(int $user_id): string
  {
    $query = "
        SELECT rank
        FROM (
          SELECT user_id, RANK() OVER (ORDER BY score DESC) as rank
          FROM game_scores
          JOIN users ON game_scores.user_id = users.id
        ) as ranking
        WHERE user_id = :user_id
    ";

    $results = DB::select($query, ["user_id" => $user_id]);

    try {
      $rank = collect($results)->firstOrFail()->rank;
    } catch (\Illuminate\Support\ItemNotFoundException $e) {
      $rank = "순위 밖";
    }

    return $rank;
  }
}
