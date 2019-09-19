<!DOCTYPE html>
<html>
  <head>
    <!-- 第一个参数是该区块的变量名称，第二个参数是默认值 -->
    <title>@yield('title', 'Weibo App') - Laravel</title>
  </head>
  <body>
    <!-- 把多余的代码从视图中抽离出来，单独创建一个默认视图来进行存放通用代码 -->
    @yield('content')
  </body>
</html>
