<?php

namespace App\Livewire;

use Livewire\Component;

class ImagePopup extends Component
{
    public $isOpen = false;
    public $src;
    public $alt;

    public function mount($src, $alt)
    {
      $this->src = $src;
      $this->alt = $alt;
    }

    public function showModal()
    {
      $this->isOpen = true;
    }

    public function closeModal()
    {
      $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.image-popup');
    }
}
