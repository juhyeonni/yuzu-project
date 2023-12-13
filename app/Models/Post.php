<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
  use HasFactory;

  protected $table = "posts";
  protected $primaryKey = "id";
  protected $fillable = ["title", "content", "user_id"];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function comments()
  {
    return $this->hasMany(Comment::class);
  }

  public function likes()
  {
    return $this->hasMany(Like::class);
  }

  public function ratings()
  {
    return $this->hasMany(Rating::class);
  }

  public function images()
  {
    return $this->hasMany(PostImage::class);
  }
}
