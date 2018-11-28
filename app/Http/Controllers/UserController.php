<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\RequestRepository;
use App\Models\User;

class UserController extends BaseController
{
    private $userRepository;
    private $requestRepository;

    public function __construct(Request $request, UserRepository $userRepository, RequestRepository $requestRepository)
    {
        parent::__construct($request);
        $this->userRepository = $userRepository;
        $this->requestRepository = $requestRepository;
    }

    public function login(Request $request)
    {
        return view('user.login');
    }

    public function postChangeUserPermission(Request $request)
    {
        $response = $this->userRepository->changeUserPermission($request);

        if ($response['success'] == false) {
            http_response_code(403);
        }
        return response()->json($response);
    }

    public function profile(Request $request, $id)
    {
        $user = $this->userRepository->find($id);
        if (is_null($user)) {
            return redirect(route('home'));
        }
        $pageTitle = trans('label.users.lbl_heading_profile');
        $listStatusRequest = array_keys(REQUEST_STATUS_TEXT);
        $allDevices = $this->requestRepository->listDevicesByUserId($id);
        $allDevicesExpired = $this->requestRepository->listDevicesByExpiredUserId($id);
        $allRequests = $this->requestRepository->listRequestByUserId($id);
        return view('user.profile', compact('pageTitle', 'allDevices', 'allDevicesExpired', 'allRequests', 'user'));
    }

    public function changeChatworkId(Request $request)
    {
        return response()->json($this->userRepository->updateChatworkId($request));
    }


    public function profileEdit($id, request $request)
    {
        $user = User::find($id);
        return view('user.profileEdit', ['user' => $user]);
    }

    public function profileUpdate($id, Request $request)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->save();

        return redirect('profile/edit/' . $user->id)->with('success', trans('profile.updateSuccess'));
    }

    public function password()
    {
        return view('user.password');
    }

    public function updateUserPassword(Request $request)
    {
        $currentUser = \Auth::user();

        if (md5($request->password) != $currentUser->password) {
            return redirect('password')->with('errors', "Sai mật khảu");
        }

        if ($request->input('password') != null) {
            $currentUser->password = md5($request->currentPassword);
        }


        $currentUser->save();

        return redirect('password')->with('success', trans('profile.updatePWSuccess'));
    }
}
