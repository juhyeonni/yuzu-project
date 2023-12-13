<div class="modal transition">
  <div wire:click="showModal">
    <img src="{{$src}}" alt="{{$alt}}" class="w-32 h-32 object-cover rounded-lg mr-2 mb-2" />
  </div>

  <div class='modal fixed w-screen h-screen top-0 left-0 bg-black bg-opacity-50 z-50 {{$isOpen ? 'flex' : 'hidden'}}' wire:click="closeModal">
    <div class="m-auto animate-modalOpen h-auto max-w-4/5 max-h-4/5" >
      <img src={{$src}} alt="{{$alt}}" class="bg-white object-cover" />
    </div>
  </div>
</div>

