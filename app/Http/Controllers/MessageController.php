<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::with(['user'])->get();

        return response()->json($messages);
    }

    public function showMessData()
    {
        
        $messages = Message::join('users', 'users.id', '=', 'messages.from_id')
        ->select('users.id as from_id', 'users.name as name', 'users.avatar as avatar', 'messages.body as message', 'messages.created_at as date', 'messages.to_id as to_id')
        ->get();

        return response()->json(["status"=>"true", "message" => $messages ]);

        // $message = $request->user()->messages()->create([
        //     'body' => $request->body
        // ]);
        // return response()->json(["status" => "kkk", "success" => true, "message" => $request->user_id]);
        // return response()->json($message);
    }

    public function showUserMess(Request $request)
    {
        // return response() ->json("okkkkkk".$request->id);

        $messages = Message::select('*')
            ->where(['to_id' => $request->to_id, 'from_id' => $request->from_id])->get();
        return response() ->json($messages);
    }

    public function createMessData(Request $request){
        
        $message = $request->message;
        $from_id = $request->from_id;
        $to_id = $request->to_id;

        $messages = Message::create([
            'from_id' => $from_id,
            'to_id' => $to_id,
            'body' => $message
        ]);
        print("show".$messages);

    }

    public function showChatData()
    {
        $messages = DB::select('SELECT
        t1.id AS id,
        t1.NAME AS name,
        t1.avatar AS avatar,
        t1.active AS active,
        t2.body AS mess,
        t2.from_id as from_id,
        t2.to_id as to_id,
        t2.created_at AS date 
    FROM
        users AS t1
        LEFT JOIN (
        SELECT
            a.* 
        FROM
            messages a
            INNER JOIN ( SELECT to_id, MAX( created_at ) max_date FROM messages GROUP BY to_id ) b ON a.to_id = b.to_id 
            AND a.created_at = b.max_date
        ) AS t2 
    on
        t1.id = t2.to_id');

        return response()->json(["status"=>"true", "message" => $messages ]);
    }
}
