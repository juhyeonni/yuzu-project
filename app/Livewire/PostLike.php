<?php

namespace App\Livewire;

use App\Models\Post;
use App\Repositories\Eloquent\PostRepository;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class PostLike extends Component
{
  protected PostRepository $postRepository;

  public Post $post;
  public bool $isLiked = false;
  public $likesCount = 0;

    public function __construct()
    {
      $this->postRepository = App::make(PostRepository::class);
    }

    public function mount($post)
    {
      $this->post = $post;
      $this->isLiked = $post->likes()->where("user_id", auth()->id())->exists();
      $this->likesCount = $post->likes()->count();
    }

    public function likeToggle(): void
    {
      if (!auth()->check()) {
        $this->likesCount = "로그인 후 이용해주세요.";
        return;
      }

      $this->postRepository->likeToggle($this->post->id);

      $this->isLiked = !$this->isLiked;
      $this->likesCount = $this->isLiked ? $this->likesCount + 1 : $this->likesCount - 1;
    }

    public function render()
    {
        return view('livewire.post-like');
    }
}
