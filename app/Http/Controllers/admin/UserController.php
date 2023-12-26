<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{
    public function index(Request $request){
        $users =User::where('role',0)->get();
        
        return View('admin.users.list',[
            'users'=>$users
        ]);
    }
    public function destroy($id){
       
        $user=User::find($id);
   
        if($user==null){
            $message='User not found';
            session()->flash('error',$message);
            return response()->json([
                'status'=>false,
                'message'=>$message
            ]);
        }
        $user->delete();
        $message='User deleted successfully';
        session()->flash('success',$message);
        return response()->json([
            'status'=>true,
            'message'=>$message
        ]);
       
      

    }
}
