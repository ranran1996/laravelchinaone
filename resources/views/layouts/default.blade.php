<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>@yield('title', 'Laravel App')- Laravel 新手入门教程</title>
  {{-- 一定要用mix不要用asset，mix() 方法与 webpack.mix.js 文件里的逻辑遥相呼应，可以解决浏览器缓存问题和CDN等问题，避免css等文件修改了，前端浏览器缓存过后，页面不改变,mix方法，文件改变后实时改变页面 --}}
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
  @include('layouts._header')

  <div class="container-fluid">
    <div class="row">
      <div class="offset-md-1 col-md-10">
        @yield('content')
        @include('layouts._footer')
      </div>
    </div>
  </div>
</body>
</html>
