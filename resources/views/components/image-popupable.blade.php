<x-modal key="{{$key}}">
  <x-slot:content>
    <img src="{{$src}}" alt="{{$alt}}" class="w-32 h-32 object-cover rounded-lg mr-2 mb-2" />
  </x-slot:content>
  <div class="m-auto animate-modalOpen bg-white" >
    <img src={{$src}} alt="{{$alt}}" class="" />
  </div>
</x-modal>


