<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class UsersController extends BaseController
{
    public function index()
    {
        $roles = Role::all()->pluck('id')->toArray();
        $users = User::orderBy('created_at', 'desc')->withTrashed()->paginate($this->pagesize);
        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|unique:users',
            'truename' => 'required',
            'password' => 'required|confirmed',
            'sex' => 'required',
            'phone' => 'required|phone',
            'email' => 'required|unique:users|email'
        ]);

        $add_user = $request->except(['_token', 'password_confirmation']);
        $add_user['password'] = bcrypt($request->password);
        $password = $request->password; // 未加密的密码
        $user = User::create($add_user);

        // 发送邮件通知
        Mail::send('mails.email', compact('user', 'password'), function (Message $message) use ($user) {
            $message->to($user->email)->subject('邮箱-新增-用户信息');
        });

        // 跳转用户列表
        return redirect()->route('admin.users.index')->with('success', '后台用户添加成功！');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return ['status' => 0, 'msg' => '删除成功！'];
    }

    public function restore($user_id)
    {
        User::withTrashed()
            ->where('id', $user_id)
            ->restore();
        return redirect()->route('admin.users.index')->with('success', '还原成功');
    }

    public function delall(Request $request)
    {
        $ids = $request->get('ids');
        User::destroy($ids);
        return ['status' => 0, 'msg' => '全选删除成功'];
    }

    // 用户列表-用户编辑
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'truename' => 'required',
            'password' => 'nullable|confirmed',
            'sex' => 'required',
            'phone' => 'required|phone',
            'email' => "required|email|unique:users,email,{$id},id"
        ]);
        $user = User::find($id);
        $update_data = $request->only(['truename', 'phone', 'sex', 'email']);

        if ($request->password) {
            $update_data['password'] = bcrypt($request->password);
        }

        if (Hash::check($request->spassword, $user->password)) {
            $user->update($update_data);
            return redirect()->route('admin.users.index')->with('success', '用户信息修改成功');
        } else {
            return redirect()->back()->withErrors('原密码错误');
        }

    }

    // 分配角色
    public function role(Request $request, User $user)
    {
        // 判断是否是post提示
        if ($request->isMethod('post')){
            $post = $this->validate($request,[
                'role_id'=>'required'
            ],['role_id.required'=>'角色必须选择']);

            $user->update($post);
            return redirect(route('admin.users.index'));
        }

        $roleAll = Role::all();
        return view('admin.users.role', compact('roleAll', 'user'));
    }
}
