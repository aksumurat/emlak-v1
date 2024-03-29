<!doctype html>
<html>
<head>
{!! SEOMeta::generate() !!}
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite([
    'resources/css/app.css',
    'resources/js/app.js'
  ])
</head>
<body class="dark:bg-slate-800 dark:text-gray-400 text-gray-800 bg-slate-200">
  <div class="min-h-screen">
    @include('layout.header')
    @yield('content')
  </div>
  <x-cookie-consent />
  @include('layout.footer')
</body>
</html>