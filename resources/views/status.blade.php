@php
  $user = auth()->user();
  $session = session()->all();
@endphp

@extends('layouts.default')

@section('main')

<div class="container mx-auto p-6 px-4 sm:px-6 lg:px-8">
  <h1 class="text-3xl font-bold mb-4">Session Information</h1>
  <div class="bg-gray-100 p-4 rounded-lg mb-8">
    <ul>
      @foreach($session as $key => $value)
        <li class="text-gray-700">{{ $key }}: {{ json_encode($value) }}</li>
      @endforeach
    </ul>
  </div>

  <h2 class="text-2xl font-bold mb-4">User Information</h2>
  <div class="bg-gray-100 p-4 rounded-lg mb-8">
    <div class="flex flex-col">
      <span class="text-gray-700 mb-2">Name:</span>
      <span class="text-lg font-bold">{{ $user->name }}</span>
    </div>
    <div class="flex flex-col">
      <span class="text-gray-700 mb-2">Email:</span>
      <span class="text-lg font-bold">{{ $user->email }}</span>
    </div>
  </div>

  <a href="{{route('user_update_form')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update User Information</a>

</div>

@endsection