<?php

namespace App\Repositories\Eloquent;

use App\Models\Comment;
use App\Repositories\LikeRepositoryInterface;
use Illuminate\Support\Facades\Gate;

class CommentRepository extends BaseRepository implements
  LikeRepositoryInterface
{
  public function __construct(Comment $model)
  {
    parent::__construct($model);
  }
  public function likeToggle(string $id)
  {
    $comment = $this->model->find($id);

    $like = $comment
      ->likes()
      ->where("user_id", auth()->user()->id)
      ->first();

    if ($like) {
      $like = $like->delete();
    } else {
      $like = $comment->likes()->create([
        "user_id" => auth()->user()->id,
      ]);
    }

    return $like;
  }

  public function store(string $content, string $id) {
    $comment = $this->model->create([
      "content" => $content,
      "post_id" => $id,
      "user_id" => auth()->user()->id,
    ]);

    return $comment;
  }

  public function update(array $data,$id){
    $comment = $this->model->find($id);
    Gate::authorize("update", $comment);
    return parent::update($data,$id);
  }

  public function delete($id){
    $comment = $this->model->find($id);
    Gate::authorize("delete", $comment);
    return parent::delete($id);
  }
}
