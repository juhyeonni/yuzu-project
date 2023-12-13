<div class='comment-container flex items-center mb-4' key="{{$id}}">
  <div class="mr-2">
    <a href="{{route('profile', $comment->user->username)}}">
      @if ($comment->user->photo)
        <img src="{{$comment->user->photo}}" alt="p" class="w-8 h-8 rounded-full">
      @else
        <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center">
          <span class="text-gray-500 text-2xl">{{$comment->user->name[0]}}</span>
        </div>
      @endif
    </a>
  </div>
  <form action="{{route("comment_delete", $comment->id)}}" method="post">
    @csrf
    @method('DELETE')
    <div class="comment-header">
      <span class="text-gray-500">{{$comment->user->name}}</span>
      <span class="text-gray-500 text-xs">{{getFomattedElapsedDatetime($comment->created_at)}}</span>
      <button class="text-gray-500 hover:text-red-400 text-sm">x</button>
    </div>
    <div class="comment-content">
      <span class="text-gray-500 text-sm">{{$comment->content}}</span>
    </div>
  </form>
</div>
