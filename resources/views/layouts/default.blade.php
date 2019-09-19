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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
          <a class="navbar-brand" href="/">Laravel App</a>
          <ul class="navbar-nav justify-content-end">
            <li class="nav-item"><a class="nav-link" href="/help">帮助</a></li>
            <li class="nav-item" ><a class="nav-link" href="#">登录</a></li>
          </ul>
        </div>
      </nav>
@yield('content')
</body>
</html>
