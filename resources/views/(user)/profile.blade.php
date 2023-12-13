@php
  $auth = auth()->user();
  if (!function_exists('getColorClass')) {
    function getColorClass($letter) {
      switch (strtoupper($letter)) {
        case 'A': return 'bg-red-200';
        case 'B': return 'bg-blue-200';
        case 'C': return 'bg-green-200';
        case 'D': return 'bg-yellow-200';
        case 'E': return 'bg-purple-200';
        case 'F': return 'bg-indigo-200';
        case 'G': return 'bg-pink-200';
        case 'H': return 'bg-red-300';
        case 'I': return 'bg-blue-300';
        case 'J': return 'bg-green-300';
        case 'K': return 'bg-yellow-300';
        case 'L': return 'bg-purple-300';
        case 'M': return 'bg-indigo-300';
        case 'N': return 'bg-pink-300';
        case 'O': return 'bg-red-400';
        case 'P': return 'bg-blue-400';
      }
    }
  }
@endphp

@extends('layouts.default')

@section('head.title')YUZU {{$user->username}} @endsection

@section('main')
  <div class="container mx-auto p-4">
    <!-- 프로필 정보 -->
      <div class="flex items-center mb-4 gap-4">
        <div class="w-24 h-24 rounded-full overflow-hidden object-cover flex items-center justify-center bg-gray-300">
          @if ($user->photo)
            <img src="{{$user->photo}}" alt="프로필 이미지" class="rounded-full" />
          @else
            <span class="text-gray-500 text-5xl ">{{$user->username[0]}}</span>
          @endif

        </div>
        <div class="ml-4">
          <h1 class="text-2xl font-bold">{{$user->username}}</h1>
          <h3 class="text-sm font-extralight">{{$user->name}}</h3>
          <p class="text-gray-600">게임 순위: 
            {{$rank}}
          </p>
        </div>
        @if ($auth && $auth->id === $user->id)
          <div class='ml-auto'>
              <a href="{{route('user_update')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">프로필 수정</a>
          </div>
        @endif
      </div>
    <!-- 게시물 목록 -->
    <span class="text-4xl">게시물 {{$user->posts()->count()}}개</span>
    <div class="grid grid-cols-5 gap-4">
      @foreach($user->posts as $post) 
        <a class="col-span-1 aspect-square relative" href="{{route('posts_detail', $post->id)}}">
          <div class="w-full h-full bg-gray-300 flex items-center justify-center {{ getColorClass($post->title[0]) }}">
            @if ($post->images()->first()) 
              <img src="{{$post->images()->first()->url}}" alt="게시물 이미지" class="w-full h-full object-cover bg-white">
            @else
              <span class="text-gray-500 text-5xl overflow-hidden whitespace-nowrap overflow-ellipsis ">{{$post->title}}</span>
            @endif
          </div>
          <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-200">
            <p class="text-white text-wrap">{{$post->content}}</p>
          </div>
        </a>
      @endforeach
    </div>
  </div>

@endsection
