@extends('layouts.default')

@section('head.title')login @endsection

@section('main')
  <x-alert />

  <div class="flex flex-col justify-center items-center h-screen">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
      <form action="{{route('login')}}" method="post">
        @csrf
        <div class="mb-4">
          <label for="email" class="block text-gray-700 font-bold mb-2">이메일:</label>
          <input class='shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline' type="email" id="email" name="email" required placeholder="email">
        </div>

        <div class="mb-4">
          <label for="password" class="block text-gray-700 font-bold mb-2">비밀번호:</label>
          <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="password" id="password" name="password" required placeholder="password">
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" >로그인</button>
      </form>

      <div class='mt-4'>
        <p>아직 계정이 없으신가요? <a href="/register" class="text-blue-500 hover:text-opacity-80">여기서 가입하기</a>.</p>
      </div>
    </div>
  </div>
@endsection
