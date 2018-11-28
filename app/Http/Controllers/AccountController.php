<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\RequestRepository;
use App\Models\User;

class AccountController extends BaseController
{
    private $userRepository;
    private $requestRepository;

    public function __construct(Request $request, UserRepository $userRepository, RequestRepository $requestRepository)
    {
        parent::__construct($request);
        $this->userRepository = $userRepository;
        $this->requestRepository = $requestRepository;
    }

    public function index()
    {
        $users = User::all();
        return view('user.list', ['users' => $users]);
    }

    public function destroy($id)
    {
        $users = User::destroy($id);

        return redirect('account');
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('user.edit', ['user' => $user]);
    }

    public function update($id, Request $request)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->nhom_tai_khoan = $request->nhom_tai_khoan;
        $user->phone = $request->phone;
        $user->save();
        return redirect('account');
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        User::insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => md5($request->password),
            'nhom_tai_khoan' => $request->nhom_tai_khoan,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);
        return redirect('account');
    }




}
