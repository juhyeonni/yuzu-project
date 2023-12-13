<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ImagePopupable extends Component
{
  /**
   * Create a new component instance.
   */
  public function __construct(
    public string $key,
    public string $src,
    public string $alt = ""
  ) {
    //
  }

  /**
   * Get the view / contents that represent the component.
   */
  public function render(): View|Closure|string
  {
    return view("components.image-popupable");
  }
}
