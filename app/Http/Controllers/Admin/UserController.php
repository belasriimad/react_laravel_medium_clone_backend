<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.users.index')->with([
            'users' => $users
        ]);
    }

    /**
     * Delete user
     */
    public function destroy(User $user)
    {
        //
        if (File::exists($user->image)) {
            File::delete($user->image);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with([
            'success' => 'User has been deleted successfully'
        ]);
    }
}
