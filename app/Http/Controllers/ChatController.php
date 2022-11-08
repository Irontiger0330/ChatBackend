<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index()
    {
        return view('chat');
    }

    public function showData($data)
    {
        // $messages = User::where('remember_token = 1')
        //                 ->select('id', 'name')->get();

        return response()->json(["status"=>"true", "message" => $data ]);
    }
}
