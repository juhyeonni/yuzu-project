@php
  $currentUser = auth()->user();
@endphp

<div class="flex items-center justify-between px-4 py-2 {{ $currentUser && $currentUser->id == $user->id ? 'border-yellow-500 border' : 'border-b' }}">
  <div class="flex items-center gap-3">
    <div>
      @if ($user->photo)
        <img src="{{$user->photo}}" alt="p" class="w-10 h-10 rounded-full">
      @else
        <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center">
          <span class="text-gray-500 text-2xl">{{$user->username[0]}}</span>
        </div>
      @endif
    </div>
    <div>
        <p class="font-bold">{{ $user->username }}</p>
        <p class="text-sm text-gray-500">랭크: {{ $user->rank }}</p>
    </div>
  </div>
  <p class="font-bold">{{ $user->score }}</p>
</div>