@extends('layouts.default')

@section('head.title')YUZU 게시글 @endsection

@section('main')

<div class="max-w-screen-lg mx-auto p-6 px-4 sm:px-6 lg:px-8 ">
  <h2 class="text-2xl font-bold mb-4">게시글 리스트</h2>
  {{--  게시글 작성 스타일 만들기 --}}
  <div class="flex justify-end mb-4">
    <a href="{{route('post_write')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">글쓰기</a>
  </div>
  <div class="overflow-x-auto ">
    <div>
      <table class="table-auto leading-normal w-full">
        <thead>
          <tr>
            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width: 50%;">제목</th>
            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width: 25%;">작성자</th>
            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width: 25%;">작성일</th>
          </tr>
        </thead>
        <tbody>
          @foreach($posts as $post)
            <tr class="cursor-pointer hover:backdrop-brightness-95 " onclick="location.href='/posts/{{$post->id}}'">
              <td class="px-5 py-5 border-b border-gray-200 text-sm" style="width: 50%;">
                <div class="flex items-center">
                  <div class="ml-3">
                    <p class="text-gray-900 whitespace-normal">
                      {{$post->title}}
                    </p>
                  </div>
                </div>
              </td>
              <td class="px-5 py-5 border-b border-gray-200 text-sm" style="width: 25%;">
                <p class="text-gray-900 whitespace-normal">{{$post->user->name}}</p>
              </td>
              <td class="px-5 py-5 border-b border-gray-200 text-sm" style="width: 25%;">
                <p class="text-gray-900 whitespace-normal">{{$post->created_at}}</p>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="mt-4">
    {{$posts->links()}}
  </div>
</div>


@endsection
