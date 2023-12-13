
@extends('layouts.default')

@section('head.title')유자 캐치 랭킹@endsection

@section('main')

<div class="container mx-auto px-4">
  <div class="w-full md:w-1/2 mx-auto">
      <h2 class="text-2xl font-bold mb-4">랭킹 리스트 (1 ~ 10)</h2>
      @foreach($rankingList as $user)
          <a href="{{route('profile', $user->username)}}">
              @component('components.ranking-user-profile', ['user' => $user])
              @endcomponent
          </a>
      @endforeach
  </div>

  <div class="w-full md:w-1/2 mx-auto mt-8">
      <h2 class="text-2xl font-bold mb-4">근처 랭킹 리스트</h2>
      @if (auth()->check())
          @forelse($nearRankingList as $user)
              <a href="{{route('profile', $user->username)}}">
                  @component('components.ranking-user-profile', ['user' => $user])
                  @endcomponent
              </a>
          @empty
          <div class="relative">
              <div class="filter blur-sm">
                  @foreach($rankingList->take(3) as $user)
                          @component('components.ranking-user-profile', ['user' => $user])
                          @endcomponent
                  @endforeach
              </div>
              <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                  <div class="flex items-center justify-center text-left">
                      <div >
                          <p class="text-xl font-bold mb-4">현재 게임 전적이 없습니다.</p>
                          <a href="{{ route('home') }}" class="text-blue-500">게임페이지로!</a>
                      </div>
                  </div>
              </div>
          </div>
          @endforelse
      @else
          <div class="relative">
              <div class="filter blur-sm">
                  @foreach($rankingList->take(3) as $user)
                      @component('components.ranking-user-profile', ['user' => $user])
                      @endcomponent
                  @endforeach
              </div>
              <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                  <div class="flex items-center justify-center h-screen text-left">
                      <div >
                          <p class="text-xl font-bold mb-4">나의 랭크는?</p>
                          <a href="{{ route('login') }}" class="text-blue-500">로그인</a>
                      </div>
                  </div>
              </div>
          </div>
      @endif
  </div>
</div>
@endsection