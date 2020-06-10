<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Users;
use Session;

class NotificationMessagesController extends Controller
{
    /*admin insert DB*/ 
    public function addNotificationMessage(Request $request) {
        $data = $request->all();
        DB::table('notification_messages')->insert([
            'from' => $data['from'],
            'to' => $data['to'],
            'title' => $data['title'],
            'body' => $data['body'],
            'page' => $data['page'],
            'is_read' => $data['is_read'],
            'created_at' => date('Y-m-d H:i:s')
        ]);
        return $data;
    }
    /*end admin insert DB*/ 


    public function readNotificationMsg(Request $request) {
        if($request->isMethod('post')) {
            $my_id = Auth::id();
            $admin_id = Session::get('adminID');
            if($request->from == "users") {
                DB::table('notification_messages')->where(['to' => $my_id])->update(['is_read' => 1]);
                return "users";
            } else if($request->from == "admin") {
                DB::table('notification_messages')->where(['to' => $admin_id])->update(['is_read' => 1]);
                return "admin";
            }
        }

        return($request->all());
    }


    public function getNotificationData(Request $request) {
        if($request->isMethod('post')) {
            
            if($request->to == Auth::id()) {
                $notifyMsg = DB::table('notification_messages')
                ->leftJoin('users', 'notification_messages.from', '=', 'users.id')
                ->where(['notification_messages.to' =>Auth::id()])
                ->orderBy('notification_messages.created_at','DESC')
                // ->offset(0)->limit(10)
                ->select('notification_messages.id','notification_messages.from','notification_messages.to','notification_messages.title',
                'notification_messages.body','notification_messages.page','notification_messages.is_read','notification_messages.created_at', 'users.name')
                ->get();
                return $notifyMsg;
            } else if($request->to == Session::get('adminID')) {
                $notifyMsg = DB::table('notification_messages')
                ->leftJoin('users', 'notification_messages.from', '=', 'users.id')
                ->where(['notification_messages.to' => Session::get('adminID')])
                ->orderBy('notification_messages.created_at','DESC')
                // ->offset(0)->limit(10)
                ->select('notification_messages.id','notification_messages.from','notification_messages.to','notification_messages.title',
                'notification_messages.body','notification_messages.page','notification_messages.is_read','notification_messages.created_at', 'users.name')
                ->get();
                return $notifyMsg;   
            }
        }
    }


    /*front insert DB*/ 
    public function addNotificationFrontMessage(Request $request) {
        $data = $request->all();
        DB::table('notification_messages')->insert([
            'from' => $data['from'],
            'to' => $data['to'],
            'title' => $data['title'],
            'body' => $data['body'],
            'page' => $data['page'],
            'is_read' => $data['is_read'],
            'created_at' => date('Y-m-d H:i:s')
        ]);
        return $data;
    }
    /*end front insert DB*/ 
}
