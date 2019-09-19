<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//命令生成：$ php artisan make:controller StaticPagesController
class StaticPagesController extends Controller
{
    //http://weibo.test
    public function home(){
        //第一个参数是视图的路径名称，第二个参数是与视图绑定的数据，第二个参数为可选。
        return view('static_pages/home');
    }

    //http://weibo.test/help
    public function help()
    {
        return view('static_pages/help');
    }

    //http://weibo.test/about
    public function about()
    {
        return view('static_pages/about');
    }
}
