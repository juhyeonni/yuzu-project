<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Comment extends Component
{
  /**
   * Create a new component instance.
   */
  public function __construct(
    public string $name,
    public string $date,
    public string $content,
    public string $id,
    public string $liked,
    public string $likesCount
  ) {
    $this->date = date("Y-m-d H:i:s", strtotime($date));
  }

  /**
   * Get the view / contents that represent the component.
   */
  public function render(): View|Closure|string
  {
    return view("components.comment");
  }
}
