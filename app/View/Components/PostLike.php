<?php

namespace App\View\Components;

use App\Models\Post;
use App\Repositories\Eloquent\PostRepository;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PostLike extends Component
{
    public Post $post;
    public bool $isLiked = false;
    public int $likesCount = 0;
    protected PostRepository $postRepository;

    /**
     * Create a new component instance.
     */
    public function __construct(Post $post)
    {
      $this->post = $post;
      $this->likesCount = $post->likes()->count();
      $this->isLiked = $post->likes()->where("user_id", auth()->id())->exists();
    }

    public function likeToggle(): void
    {
      $this->postRepository->likeToggle($this->post->id);
      $this->isLiked = !$this->isLiked;
      $this->likesCount = $this->isLiked ? $this->likesCount + 1 : $this->likesCount - 1;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.post-like');
    }
}
