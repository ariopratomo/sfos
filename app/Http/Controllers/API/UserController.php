<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
// userResource
use App\Http\Resources\UserResource;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $can = can('user-list');
        if ($can) {
            $users = User::all();
            return $this->sendResponse(UserResource::collection($users), 'Users retrieved successfully.');


            // return $this->sendResponse($users, 'User list.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $can = can('user-create');
        if ($can) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'c_password' => 'required|same:password',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $success = User::create($input);
            return $this->sendResponse($success, 'User register successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $can = can('user-list');
        if ($can) {
            $user = User::find($id);
            if (is_null($user)) {
                return $this->sendError('User not found.');
            }
            return $this->sendResponse(new UserResource($user), 'User retrieved successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $can = can('user-edit');
        if ($can) {
            $input = $request->all();
            $validator = Validator::make($input, [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'sometimes|nullable|min:6',
                'c_password' => 'same:password',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $user = User::find($id);
            if (is_null($user)) {
                return $this->sendError('User not found.');
            }
            $user->name = $input['name'];
            $user->email = $input['email'];
            if (!empty($input['password'])) {
                $user->password = bcrypt($input['password']);
            }
            $user->save();
            return $this->sendResponse(new UserResource($user), 'User updated successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $can = can('user-delete');
        if ($can) {
            $user = User::find($id);
            if (is_null($user)) {
                return $this->sendError('User not found.');
            }
            $user->delete();
            return $this->sendResponse([], 'User deleted successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }
}
