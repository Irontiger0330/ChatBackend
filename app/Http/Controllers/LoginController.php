<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Auth\SessionGuard;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Session\Session;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        $data = $this->validate($request, ['email' => 'required|email', 'password' => 'required']);
        $email = $request->email;

        if (User::login($data)) {
            $user = User::select("*")
            ->where("email", $email)
            ->get();
            return response()->json(['status' => true, 'message' => 'login success', "data" => $user]);
        }
        return response()->json(['status' => false, 'message' => 'fix errors'], 500);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|email",
            "password" => "required",

        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "failed", "message" => "validation_error", "errors" => $validator->errors()]);
        }

        $userDataArray = array(
            "name" => $request->name,
            "email" => $request->email,
            "password" => $request->password,
            "active" => 1,
            "avatar" => 'https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp',
        );

        $user_status = User::where("email", $request->email)->first();

        if (!is_null($user_status)) {
            return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! email already registered"]);
        }

        $user = User::create($userDataArray);

        if (!is_null($user)) {
            return response()->json(["status" => "success", "message" => "Registration completed successfully", "data" => $user]);
        } else {
            return response()->json(["status" => "failed", "message" => "failed to register"]);
        }
    }

    public function logout(Request $request)
    {

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json('Successfully logged out');
    }
}
