<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameScore extends Model
{
  use HasFactory;

  protected $table = "game_scores";

  protected $primaryKey = "user_id";
  protected $fillable = ["user_id", "score"];

  public function user()
  {
    // return $this->belongsTo(User::class);
    return $this->belongsTo(User::class, "user_id", "id");
  }
}
