<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{

    // login api
    public function login(Request $request)
    {
        // check validator if input is username check username else check email
        if ($request->username) {
            $validator = Validator::make($request->all(), [
                'username' => 'required',
                'password' => 'required',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);
        }

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        // credentials username or email
        if ($request->username) {
            $credentials = [
                'username' => $request->username,
                'password' => $request->password,
            ];
        } else {
            $credentials = [
                'email' => $request->email,
                'password' => $request->password,
            ];
        }

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $success['token'] = $user->createToken('sfosApp')->accessToken;
            return $this->sendResponse($success, 'User login successfully.', 200);
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    // logout api
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return $this->sendResponse([], 'User logout successfully.', 200);
    }

    // get user details
    public function me(Request $request)
    {
        $user = $request->user();
        return $this->sendResponse($user, 'User details.', 200);
    }

    // check permission
    public function checkPermission(Request $request)
    {
        $permissionReq = $request->permission;
        $user = Auth::user();
        $permissions = $user->getAllPermissions();
        $permissionArray = [];

        foreach ($permissions as $permission) {
            $permissionArray[] = $permission->name;
        }

        if (in_array($permissionReq, $permissionArray)) {
            return $this->sendResponse([], 'Permission granted.', 200);
        } else {
            return $this->sendError('Permission denied.', ['error' => 'Permission denied'], 401);
        }
    }
}
