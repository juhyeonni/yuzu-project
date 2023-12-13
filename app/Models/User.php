<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;

  protected $table = "users";
  protected $primaryKey = "id";

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = ["name", "email", "password", "photo"];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = ["password", "remember_token"];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    "email_verified_at" => "datetime",
    "password" => "hashed",
  ];

  public function roles(): BelongsToMany
  {
    return $this->belongsToMany(Role::class);
  }

  public function posts()
  {
    return $this->hasMany(Post::class);
  }

  public function goods(): BelongsToMany
  {
    return $this->belongsToMany(Good::class)
      ->as("order")
      ->withPivot(["ordered_at", "amount"]);
  }

  public function gameScore(): HasOne
  {
    return $this->hasOne(GameScore::class);
  }
}
