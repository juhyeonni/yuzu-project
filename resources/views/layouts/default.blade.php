<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @vite('resources/css/app.css')
  <title>@yield('head.title', env('APP_NAME'))</title>
  @livewireStyles
</head>
<body>
  <x-header />

  <hr />

  @yield('main')

  <hr />

  <x-footer />
  @livewireScripts
</body>
</html>
