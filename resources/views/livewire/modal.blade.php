<div class="modal transition">
  <div wire:click="showModal">
    'something'
  </div>

  <div class='modal fixed w-screen h-screen top-0 left-0 bg-black bg-opacity-50 z-50 {{$isOpen ? 'flex' : 'hidden'}}' wire:click="closeModal">
    <div class="m-auto animate-modalOpen" >
      'something"
    </div>
  </div>
</div>
