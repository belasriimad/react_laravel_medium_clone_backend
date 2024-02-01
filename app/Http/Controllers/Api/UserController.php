<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AuthUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Store new user
     */
    public function store(StoreUserRequest $request)
    {
        //validate the data
        if ($request->validated()) {
            //create new user
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            //return the response
            return response()->json([
                'message' => 'Account has been created successfully'
            ]);
        }
    }

    /**
     * Log in the user
     */
    public function auth(AuthUserRequest $request)
    {
        //validate the data
        if ($request->validated()) {
            //fetch user by email
            $user = User::whereEmail($request->email)->first();
            //check if the user exists and the stored password is the same as
            //the provided one
            if (!$user || !Hash::check($request->password, $user->password)) {
                //return the response
                return response()->json([
                    'error' => 'These credentials do not match any of our records.'
                ]);
            }else {
                //return the response
                return response()->json([
                    'user' => UserResource::make($user),
                    'access_token' => $user->createToken('new_user')->plainTextToken
                ]);
            }
        }
    }
    
    /**
     * Logout the user
     */
    public function logout(Request $request)
    {
        //delete the current token of the currently logged in user
        $request->user()->currentAccessToken()->delete();
        //return the response
        return response()->json([
            'message' => 'Logged out successfully.'
        ]);
    }

    /**
     * Follow users
     */
    public function follow(Request $request)
    {
        //get the follower and the user tha he wants to follow
        $follower = User::findOrFail($request->follower_id);
        $following = User::findOrFail($request->following_id);
        //follow the user
        $follower->followings()->attach($following);
        //return the response
        return response()->json([
            'follower' => UserResource::make($follower),
            'following' => UserResource::make($following)
        ]);
    }

    /**
     * Unfollow users
     */
    public function unfollow(Request $request)
    {
        //get the follower and the user tha he wants to unfollow
        $follower = User::findOrFail($request->follower_id);
        $following = User::findOrFail($request->following_id);
        //unfollow the user
        $follower->followings()->detach($following);
        //return the response
        return response()->json([
            'follower' => UserResource::make($follower),
            'following' => UserResource::make($following)
        ]);
    }

    /**
     * Update user informations
     */
    public function updateUserInfos(UpdateUserRequest $request)
    {
        if ($request->validated()) {
            if ($request->has('image')) {
                //remove the previous user image
                if (File::exists($request->user()->image)) {
                    File::delete($request->user()->image);
                }
                //save the new user image and get the file name
                $file = $request->file('image');
                $request->user()->image = 'storage/users/images/'.$this->saveImage($file);
            }

            //update the user
            $request->user()->update([
                'name' => $request->name,
                'email' => $request->email,
                'bio' => $request->bio
            ]);
            //return the response
            return response()->json([
                'user' => UserResource::make($request->user()),
                'message' => 'Your profile has been updated successfully.'
            ]);
        }
    }

    /**
     * Save images in the storage
     */
    public function saveImage($file)
    {
        $file_name = time().'_'.'user'.'_'.$file->getClientOriginalName();
        $file->storeAs('users/images/', $file_name, 'public');
        return $file_name;
    }

    /**
     * Update user password
     */
    public function updateUserPassword(Request $request)
    {
        //validate the data
        $this->validate($request, [
            'currentPassword' => 'required|min:6|max:255',
            'newPassword' => 'required|min:6|max:255'
        ]);
        //check if the current password is the same as the stored one
        if (!Hash::check($request->currentPassword, $request->user()->password)) {
            //if not the same
            return response()->json([
                'error' => 'The current password is incorrect.'
            ]);
        }else {
            //update the user password
            $request->user()->update([
                'password' => Hash::make($request->newPassword)
            ]);
            //return the response
            return response()->json([
                'message' => 'Your password has been updated successfully.'
            ]);
        }
    }
}
