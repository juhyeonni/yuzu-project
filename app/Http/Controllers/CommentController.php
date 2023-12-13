<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Repositories\Eloquent\CommentRepository;
use Illuminate\Http\Request;

class CommentController extends Controller
{
  public function __construct(protected CommentRepository $commentRepository)
  {
  }

  public function store(StoreCommentRequest $request, string $id)
  {
    $validated = $request->validated();

    $comment = $this->commentRepository->store(
      $validated['content'],
      $id
      );

    return redirect()->route("posts_detail", ["id" => $id]);
  }

  public function destroy(string $id)
  {
    $comment = $this->commentRepository->delete($id);

    return redirect()->back();
  }

  public function likeToggle(string $id)
  {
    $like = $this->commentRepository->likeToggle($id);

    return response()->json($like);
  }
}
