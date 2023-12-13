<?php

namespace App\View\Components;

use App\Http\Middleware\Authenticate;
use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class Header extends Component
{
  public string|null $title = null;
  public User|null $user;

  /**
   * Create a new component instance.
   */
  public function __construct()
  {
    $this->title = config("app.name");
    $this->user = auth()->user();
  }

  /**
   * Get the view / contents that represent the component.
   */
  public function render(): View|Closure|string
  {
    return view("components.common.header");
  }
}
