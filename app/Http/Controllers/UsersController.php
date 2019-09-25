<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Mail;


class UsersController extends Controller
{

    //PHP 的构造器方法，当一个类对象被创建之前该方法将会被调用。
    public function __construct()
    {
        //第一个为中间件的名称，第二个为要进行过滤的动作
        $this->middleware('auth', [
            //除了此处指定的动作以外，所有其他动作都必须登录用户才能访问
            'except' => ['show', 'create', 'store', 'index', 'confirmEmail']
        ]);
    }

    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

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
    // public function store(Request $request)
    // {
    //     $this->validate($request, [
    //         'name' => 'required|max:50',
    //         'email' => 'required|email|unique:users|max:255',
    //         'password' => 'required|confirmed|min:6'
    //     ]);

    //     $user = User::create([
    //         //获得用户的所有输入数据
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => bcrypt($request->password),
    //     ]);

    //     //注册后自动登录
    //     Auth::login($user);

    //     //使用 session() 方法来访问会话实例。而当我们想存入一条缓存的数据，让它只在下一次的请求内有效时，则可以使用 flash 方法。danger, warning, success, info
    //     session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
    //     //route() 方法会自动获取 Model 的主键
    //     return redirect()->route('users.show', [$user]);
    // }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $this->sendEmailConfirmationTo($user);
        session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收。');
        return redirect('/');
    }

//    protected function sendEmailConfirmationTo($user)
//    {
//        $view = 'emails.confirm';
//        $data = compact('user');
//        $from = 'summer@example.com';
//        $name = 'Summer';
//        $to = $user->email;
//        $subject = "感谢注册 Weibo 应用！请确认你的邮箱。";
//
//        Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
//            $message->from($from, $name)->to($to)->subject($subject);
//        });
//    }

    protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $to = $user->email;
        $subject = "感谢注册 Weibo 应用！请确认你的邮箱。";

        Mail::send($view, $data, function ($message) use ($to, $subject) {
            $message->to($to)->subject($subject);
        });
    }

    public function confirmEmail($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success', '恭喜你，激活成功！');
        return redirect()->route('users.show', [$user]);
    }

    //get /users/{user}/edit
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    // patch /users/{user}
    public function update(User $user, Request $request)
    {
        //update 是指授权类里的 update 授权方法，$user 对应传参 update 授权方法的第二个参数
        $this->authorize('update', $user);

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

    public function destroy(User $user)
    {
        $user->delete();
        session()->flash('success', '成功删除用户！');
        return back();
    }
}
