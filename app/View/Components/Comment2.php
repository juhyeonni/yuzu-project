<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Comment;

class Comment2 extends Component
{
  public Comment|null $comment = null;
  /**
   * Create a new component instance.
   */
  public function __construct(public string $id)
  {
    $this->comment = Comment::with("user", "commentLikes")->find($id);
  }

  /**
   * Get the view / contents that represent the component.
   */
  public function render(): View|Closure|string
  {
    return view("components.comment2");
  }
}
