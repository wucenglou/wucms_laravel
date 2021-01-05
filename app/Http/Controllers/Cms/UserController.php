<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public $successStatus = 200;

    // 注册页面
    // public function index()
    // {
    //     return view('/admin/login/register');
    // }

    public function register(Request $request)
    {

        $data = $request->all();
        $input['name'] = $data['username'];
        $input['password'] = bcrypt($data['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken(env('APP_CMS'))->accessToken;
        $success['name'] =  $user->name;

        return response()->json(['data' => $success], 200);
    }

    public function login(Request $request)
    {
        $data = $request->all();
        if (Auth::attempt(['name' => $data['username'], 'password' => $data['password']])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken(env('APP_CMS'))->accessToken;
            return response()->json(['token' => $success['token'], 'code' => 20000], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }

    }

    public function getuser()
    {
        $user = Auth::guard('admin')->user();
        return response()->json($user);
    }

    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }
}
