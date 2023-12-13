@php
  $user = auth()->user();
@endphp

@extends('layouts.default')

@section('head.title')update user @endsection

@section('main')
  <h1 class="text-3xl font-bold mb-8">유저 정보 업데이트</h1>

  <x-alert />

  <form action="{{ route('user_update') }}" method="POST" class="max-w-2xl mx-auto" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="flex gap-4">
      <div class="w-full">
        <div class="mb-4">
          <label for="name" class="block text-gray-700 font-bold mb-2">이름:</label>
          <input type="text" name="name" id="name" value="{{ $user->name }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
          <label for="username" class="block text-gray-700 font-bold mb-2">닉네임:</label>
          <input type="text" name="username" id="username" value="{{ $user->username }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
          <label for="email" class="block text-gray-700 font-bold mb-2">이메일:</label>
          <input type="email" name="email" id="email" value="{{ $user->email }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
          <label for="password" class="block text-gray-700 font-bold mb-2">비밀번호:</label>
          <input type="password" name="password" id="password" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
      </div>
      <label class='w-fit h-fit'>
        <div class="w-20 h-20 rounded-full overflow-hidden object-cover flex items-center justify-center bg-gray-300 relative ">
          @if ($user->photo)
            <img src="{{$user->photo}}" id="avatar" alt="프로필 이미지" class="rounded-full" />
          @else
            <span id="avatar" class="text-gray-500 text-4xl ">{{$user->name[0]}}</span>
          @endif
          <div class='absolute opacity-5 hover:opacity-70 transition-opacity duration-200'>
            <x-icon-upload />
          </div>
        </div>
        <input type="file" name="photo" id="uploadImage" class="border rounded-lg py-2 px-3 mb-4 w-full" hidden accept=".png, .jpg, .jpeg"/>
      </label>
    </div>

    <div class="mb-4">
      <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" id="btnChangePassword">비밀번호 바꾸기</button>
      <div id="newPasswordForm" class="hidden">
        <label for="newPassword" class="block text-gray-700 font-bold mb-2">새 비밀번호:</label>
        <input id="newPassword" type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="new_password" />
        <label for="newPasswordConfirm" class="block text-gray-700 font-bold mb-2">새 비밀번호 확인:</label>
        <input id="newPasswordConfirm" type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="new_password_confirmation" />
      </div>
    </div>

    <div class="flex items-center justify-between">
      <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">수정하기</button>
    </div>
  </form>

  <script>
    const changePassword = document.getElementById('btnChangePassword');
    changePassword.addEventListener('click', () => {
      newPasswordForm.classList.toggle('hidden');
    });

    const newPasswordForm = document.getElementById('newPasswordForm');
    const newPassword = newPasswordForm.querySelector('#newPassword');
    const newPasswordConfirm = newPasswordForm.querySelector('#newPasswordConfirm');

    function validatePassword() {
      if (newPassword.value !== newPasswordConfirm.value) {
        newPasswordConfirm.setCustomValidity('Passwords do not match');
        return;
      }
      if (newPassword.value.length < 8) {
        newPasswordConfirm.setCustomValidity('Password must be at least 8 characters');
        return;
      }

      newPasswordConfirm.setCustomValidity('');
    }

    const avatarElement = document.getElementById('avatar');

    const uploadImage = document.getElementById('uploadImage');
    uploadImage.addEventListener('input', (e) => {
      const url = URL.createObjectURL(e.target.files[0]);
      const newAvatar = createAvatar(url);

      avatarElement.replaceWith(newAvatar);
    });

    function createAvatar(url) {
      const avatar = document.createElement('img');
      avatar.src = url;
      avatar.classList.add('rounded-full');

      return avatar;
    }

  </script>

@endsection

