<button class="text-white font-bold py-2 px-4 rounded-full {{$isLiked ? 'bg-red-400 hover:bg-red-500 animate-shakeAndGrow' : 'bg-blue-500 hover:bg-blue-700 '}}" wire:click="likeToggle">
  <span class="mr-2">{{$isLiked ? '♥︎' : '♡'}}</span>
  <span>{{$likesCount}}</span>
</button>
