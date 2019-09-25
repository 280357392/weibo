<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use Auth;

//命令生成：$ php artisan make:controller StaticPagesController
class StaticPagesController extends Controller
{
    //http://weibo.test
    public function home()
    {
        $feed_items = [];
        if (Auth::check()) {
            $feed_items = Auth::user()->feed()->paginate(30);
        }
        //第一个参数是视图的路径名称，第二个参数是与视图绑定的数据，第二个参数为可选。
        return view('static_pages/home', compact('feed_items'));
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
