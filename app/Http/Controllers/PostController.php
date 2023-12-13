<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Repositories\Eloquent\PostImageUploadRepository;
use Illuminate\Http\Request;

use App\Repositories\Eloquent\PostRepository;
use Termwind\Components\Dd;

class PostController extends Controller
{
  public function __construct(
    protected PostRepository $postRepository,
    protected PostImageUploadRepository $postImageUploadRepository
  ) {
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $each = $request->input("each") ?? 10;
    $posts = $this->postRepository->paginate($each);
    return view("(post).list", compact("posts"));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view("(post).write");
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StorePostRequest $request)
  {
    $validated = $request->validated();

    $post = $this->postRepository->create($validated);

    if (isset($validated["images"])) {
      $this->postImageUploadRepository->uploadImages(
        $validated["images"],
        $post->id
      );
    }

    return redirect()->route("posts");
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    $post = $this->postRepository->show($id);
    return view("(post).detail", [
      "post" => $post,
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    $post = $this->postRepository->show($id);
    return view("(post).edit", $post);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdatePostRequest $request, string $id)
  {
    $validated = $request->validated();
    $this->postRepository->update($validated, $id);

    if (isset($validated["images"])) {
      $this->postImageUploadRepository->uploadImages($validated["images"], $id);
    }

    return redirect()->route("posts_detail", $id);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $request, string $id)
  {
    $this->postRepository->delete($id);

    return redirect()->route("posts");
  }

  /**
   * Search for posts based on a keyword.
   */
  public function search(Request $request)
  {
    $keyword = $request->input("keyword");

    $posts = $this->postRepository->search($keyword);

    return response()->json($posts);
  }

  public function likeToggle(string $id)
  {
    $like = $this->postRepository->likeToggle($id);

    return response()->json($like);
  }
}
