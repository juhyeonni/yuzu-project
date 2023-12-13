@php
  $auth = auth()->user();
@endphp
@extends('layouts.default')

@section('head.title'){{$post->title}}@endsection

@section('main')

<a href="javascript:window.history.back();">back</a>
<div class="max-w-screen-md mx-auto p-6 px-4 sm:px-6 lg:px-8 bg-white rounded-lg shadow-lg">
  @if ($auth && $auth->id === $post->user->id)
    <div class="flex justify-end space-x-2">
      <a href="{{route('post_edit', $post->id)}}" id='edit'>
        <span>edit</span>
      </a>

      <button id='delete'>
        <span>delete</span>
      </button>
    </div>
  @endif
  <div class="mb-4">
    <h2 class="text-bold text-6xl">{{$post->title}}</h2>
  </div>
  <div class="flex flex-col mb-4">
    <a href="{{route('profile', $post->user->username)}}" class="flex items-center gap-2">
      <div class="w-8 h-8 rounded-full overflow-hidden object-cover flex items-center justify-center bg-gray-300">
        @if ($post->user->photo)
          <img src="{{$post->user->photo}}" alt="프로필 이미지" class="rounded-full" />
        @else
          <span class="text-gray-500 text-2xl ">{{$post->user->name[0]}}</span>
        @endif
      </div>
      <span class="text-sm font-thin">작성자: {{$post->user->name}}</span>
    </a>
    <span class="text-sm font-thin">작성시간: {{ date('Y-m-d / h:i A', strtotime($post->created_at)) }}</span>
  </div>

  <div id="images" class="flex">
    @foreach($post->images as $key => $image)
      <livewire:image-popup src="{{asset($image->url)}}" alt="images {{$key}}" />
    @endforeach
  </div>

  <div>
    <label class="block font-bold mb-2">Content:</label>
    <textarea name="content" id="content" cols="30" rows="10" readonly class="border rounded-lg py-2 px-3 mb-4 w-full resize-none h-auto" readonly>{{$post->content}}</textarea>
  </div>

  <livewire:post-like :post="$post" />

  <hr class="mt-8" />

  <div id="comment" class="mt-6">
    <h2 class="text-lg font-bold mb-1">Comments:</h2>
    @foreach($post->comments as $comment)
      <x-comment2 :id="$comment['id']"/>
    @endforeach
  </div>
    @if($auth)
      <form action="{{route('comment_store', $post->id)}}" method="post" class="flex items-center space-x-3">
        @csrf
        <input name="content" id="content" class="border rounded-lg py-2 px-3 flex-grow" placeholder="댓글을 입력하세요..."/>
        <button type="submit" class="text-gray-800 font-bold py-2 px-4 rounded">게시</button>
      </form>
    @endif
</div>
<script>
  const originPostDeleteBtn = document.querySelector('#delete');
  if (originPostDeleteBtn) {
    originPostDeleteBtn.addEventListener('click', () => {
      if (confirm('삭제하시겠습니까?')) {
        fetch('{{route("delete", $post->id)}}', {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
        }).then((res) => {
          console.log(res)
          location.href = '/posts';
        }).catch((err) => {
          alert('삭제 실패');
          console.error(err);
        })
      }
  })

  }
</script>

@endsection
