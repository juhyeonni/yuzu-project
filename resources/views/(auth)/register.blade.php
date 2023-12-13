@extends('layouts.default')

@section('head.title')register @endsection

@section('main')
  <x-alert />

  <div class="flex justify-center items-center h-screen">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
      <form action="{{route('register')}}"  method='post'>
        @csrf
        <div class="mb-4">
          <label class="block text-gray-700 font-bold mb-2" for="name">
            이름:
          </label>
          <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" name="name" required placeholder="name">
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 font-bold mb-2" for="email">
            이메일:
          </label>
          <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="email" name="email" required placeholder="email">
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 font-bold mb-2" for="password">
            비밀번호:
          </label>
          <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" name="password" required placeholder="password">
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 font-bold mb-2" for="password_confirmation">
            비밀번호 확인:
          </label>
          <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password_confirmation" type="password" name="password_confirmation" required placeholder="password confirmation">
        </div>

        <div class="flex items-center justify-between">
          <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
            가입하기
          </button>
        </div>
      </form>
    </div>
  </div>

@endsection