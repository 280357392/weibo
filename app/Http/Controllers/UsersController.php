<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;


class UsersController extends Controller
{
    //get /users/create
     public function create()
    {
        return view('users.create');
    }

    //get users/{user}
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    //post /users
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            //获得用户的所有输入数据
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        //注册后自动登录
        Auth::login($user);

        //使用 session() 方法来访问会话实例。而当我们想存入一条缓存的数据，让它只在下一次的请求内有效时，则可以使用 flash 方法。danger, warning, success, info
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        //route() 方法会自动获取 Model 的主键
        return redirect()->route('users.show', [$user]);
    }


    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(User $user, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', '个人资料更新成功！');

        return redirect()->route('users.show', $user);
    }
}
