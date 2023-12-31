<?php

namespace App\Repositories\Eloquent;

use App\Models\Post;
use App\Repositories\LikeRepositoryInterface;
use App\Repositories\PostRepositoryInterface;
use Illuminate\Support\Facades\Gate;

class PostRepository extends BaseRepository implements
  PostRepositoryInterface,
  LikeRepositoryInterface
{
  public function __construct(Post $model)
  {
    parent::__construct($model);
  }

  public function paginate($perPage = 5)
  {
    return $this->model
      ->with("user")
      ->orderBy("created_at", "desc")
      ->paginate($perPage);
  }

  public function create(array $data)
  {
    return $this->model->create([...$data, "user_id" => auth()->user()->id]);
  }

  public function show($id)
  {
    $post = $this->model
      ->with("user", "comments", "likes", "images")
      ->find($id);

    return $post;
  }

  public function search(string $keyword)
  {
    $query = $this->model->query();

    if ($keyword) {
      $query
        ->where("title", "like", "%" . $keyword . "%")
        ->orWhere("content", "like", "%" . $keyword . "%");
    }

    return $query->paginate(5);
  }

  public function update(array $data, $id)
  {
    $post = $this->model->find($id);
    Gate::authorize("update", $post);
    return parent::update($data, $id); // TODO: Change the autogenerated stub
  }

  public function delete($id)
  {
    $post = $this->model->find($id);
    Gate::authorize("delete", $post);
    return parent::delete($id); // TODO: Change the autogenerated stub
  }

  public function likeToggle(string $id)
  {
    $post = $this->model->find($id);

    $like = $post
      ->likes()
      ->where("user_id", auth()->user()->id)
      ->first();

    if ($like) {
      $like = $like->delete();
    } else {
      $like = $post->likes()->create([
        "user_id" => auth()->user()->id,
      ]);
    }

    return $like;
  }
}
