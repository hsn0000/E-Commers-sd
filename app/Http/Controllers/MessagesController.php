<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; 
use Auth;
use App\Message;
use App\User;
use Session;
use Image;
use hash;
use Pusher\Pusher;

class MessagesController extends Controller
{
    /*admin*/ 
    public function messages(Request $request, $id = null) {
        // $users = DB::select("select users.id, users.name, users.avatar, users.email, count(is_read) as unread 
        // from users LEFT JOIN messages ON users.id = messages.from and is_read = 0 and messages.to = ". Auth::id() ." where users.id != ". Auth::id() ." 
        // group by users.id, users.name users.avatar, users.email");

        // $usersAll1 = DB::table('users')->where('id', '!=',$admin_id->id,)->where('admin',0)->get();
        $admin_id = Session::get('adminID');

        $usersAll = DB::table('users')
           ->leftJoin('messages as msg', 'users.id', '=', 'msg.from')
           ->whereNotIn('users.id', [$admin_id])
           ->whereNotIn('users.status', [0])
           ->whereNotIn('users.admin', [1])
           ->orderBy('name','asc')
           ->select('users.id','users.name','users.avatar','users.email', 'users.admin','users.status','msg.from','msg.to')
           ->groupBy('users.id','users.name','users.avatar','users.email')
           ->get();

           foreach($usersAll as $key => $usr){
               $countUnread = DB::table('messages')->where('to',$admin_id)->where('from', $usr->id)->where('is_read', 0)->get()->count();
               $usr->unread = $countUnread;
           }

        /*update noty db*/
        DB::table('notification_messages')->where(['to' => $admin_id])->update(['is_read' => 1]);
        /*end not db*/  

        return view('admin.messages.message')->with(\compact('usersAll','admin_id'));
    }


    public function getMessage($user_id) {
        $admin_id = Session::get('adminID');

        Message::where(['from' => $user_id, 'to' => $admin_id])->update(['is_read' => 1]);

        $messageUsers = DB::table('messages')
            ->join('users AS userfrom', 'messages.from', '=', 'userfrom.id')
            ->join('users AS userto', 'messages.to', '=', 'userto.id')
            ->where(function ($query) use ($user_id, $admin_id) {
                $query->where('from', $admin_id)->where('to', $user_id);
            })->orWhere(function($query) use ($user_id, $admin_id) {
                $query->where('from', $user_id)->where('to', $admin_id);
            })
            ->select('messages.id', 'messages.from', 'messages.to', 'messages.message', 'messages.images','messages.is_read','messages.updated_at','messages.created_at','userfrom.avatar','userfrom.name','userfrom.email')
            ->get();
    
        return view('admin.messages.index_message', ['messageUsers' => $messageUsers, 'user_id' => $user_id, 'admin_id' => $admin_id]);
    }

    public function sendMessage(Request $request) {
        // $from = Auth::id(); 
        $from = Session::get('adminID');
        $to = $request->receiver_id;
        $message = $request->message;

        $data = new Message;
        $data->from = $from;
        $data->to = $to;
        $data->message = $message;
        $data->images = "";
        $data->is_read = 0;
        $data->save(); 

        // pusher
        $options = array(
           'cluster' => 'ap1', 
           'useTLS' => true,
           'encrypted' => true
        );

        $pusher = new Pusher (
           env('PUSHER_APP_KEY'),
           env('PUSHER_APP_SECRET'),
           env('PUSHER_APP_ID'),
           $options
        );

        $data = ['from' => $from, 'to' => $to]; // sending from amd to user id when pressed enter
        $pusher->trigger('my-channel','my-event', $data);
    }


    public function uploadImgAdmMsg(Request $request) {
        if($request->hasFile('input_image_adm'))
        {
          $files = $request->file('input_image_adm');
          // upload image after resize 
          $extension = $files->getClientOriginalExtension();
          $filename = rand(111,99999).'.'.$extension;
          $messageImg_patch = 'images/messages/image/'.$filename;
          Image::make($files)->resize(1140, 1140)->save($messageImg_patch);
          
        }

        $from = Session::get('adminID');
        $to = $request->receiver_id_adm;

        $data = new Message;
        $data->from = $from;
        $data->to = $to;
        $data->message = "";
        $data->images =  $filename;
        $data->is_read = 0;
        $data->save(); 

        // pusher
        $options = array(
            'cluster' => 'ap1', 
            'useTLS' => true,
            'encrypted' => true
        );

        $pusher = new Pusher (
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data = ['from' => $from, 'to' => $to]; // sending from amd to user id when pressed enter
        $pusher->trigger('my-channel','my-event', $data);
    }

    /*end admin*/
    
    /*frontend*/
    public function frontMessages(Request $request, $id = null) {
        $my_id = Auth::id();
        $admin_id = Session::get('adminID');

        $usersAll = DB::table('users')
        ->leftJoin('messages as msg', 'users.id', '=', 'msg.from')
        ->where('users.id', '!=', $my_id)
        ->whereNotIn('users.status', [0])
        ->whereNotIn('users.admin', [0])
        ->select('users.id','users.name','users.avatar','users.email', 'users.admin','users.status','msg.from','msg.to')
        ->groupBy('users.id','users.name','users.avatar','users.email')
        ->get();

        foreach($usersAll as $key => $usr){
            $countUnread = DB::table('messages')->where('to', $my_id)->where('from',$usr->id)->where('is_read', 0)->get()->count();
            $usr->unread = $countUnread;
        }

        /*update noty db*/
        DB::table('notification_messages')->where(['to' => $my_id])->update(['is_read' => 1]);
        /*end not db*/ 
 
        return view('frontend.messages.front_message')->with(\compact('usersAll','admin_id'));
    }


    public function frontGetMessage($user_id) {
        $my_id = Auth::id();
        // $admin_id = Session::get('adminID');

        Message::where(['from' => $user_id, 'to' => $my_id])->update(['is_read' => 1]);

        $messageUsers = DB::table('messages')
            ->join('users AS userfrom', 'messages.from', '=', 'userfrom.id')
            ->join('users AS userto', 'messages.to', '=', 'userto.id')
            ->where(function ($query) use ($user_id, $my_id) {
                $query->where('from', $my_id)->where('to', $user_id);
            })->orWhere(function($query) use ($user_id, $my_id) {
                $query->where('from', $user_id)->where('to', $my_id);
            })
            ->select('messages.id', 'messages.from', 'messages.to', 'messages.message', 'messages.images','messages.is_read','messages.updated_at','messages.created_at','userfrom.avatar','userfrom.name','userfrom.email')
            ->get();

        return view('frontend.messages.index_message', ['messageUsers' => $messageUsers,'user_id' => $user_id, 'my_id' => $my_id]);
    }


    public function frontSendMessage(Request $request) {
        $from = Auth::id(); 
        $to = $request->receiver_id;
        $message = $request->message;

        $data = new Message;
        $data->from = $from;
        $data->to = $to;
        $data->message = $message;
        $data->images =  "";
        $data->is_read = 0;
        $data->save(); 

        // pusher
        $options = array(
            'cluster' => 'ap1', 
            'useTLS' => true,
            'encrypted' => true
        );

        $pusher = new Pusher (
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data = ['from' => $from, 'to' => $to]; // sending from amd to user id when pressed enter
        $pusher->trigger('my-channel','my-event', $data);
    }

    public function uploadImgFronMsg(Request $request) {

        if($request->hasFile('input_image'))
        {
          $files = $request->file('input_image');
          // upload image after resize 
          $extension = $files->getClientOriginalExtension();
          $filename = rand(111,99999).'.'.$extension;
          $messageImg_patch = 'images/messages/image/'.$filename;
          Image::make($files)->resize(1140, 1140)->save($messageImg_patch);
          
        }

        $from = Auth::id(); 
        $to = $request->receiver_id_fron;

        $data = new Message;
        $data->from = $from;
        $data->to = $to;
        $data->message = "";
        $data->images =  $filename;
        $data->is_read = 0;
        $data->save(); 

        // pusher
        $options = array(
            'cluster' => 'ap1', 
            'useTLS' => true,
            'encrypted' => true
        );

        $pusher = new Pusher (
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data = ['from' => $from, 'to' => $to]; // sending from amd to user id when pressed enter
        $pusher->trigger('my-channel','my-event', $data);

    }

    /*frontend*/  
}
