<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Deposite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepositeController extends Controller
{
    public function index(){
        $data=[];
        $users=User::orderBy('name','ASC')->where('role',0)->get();
        $deposites=Deposite::latest();
        $deposites=$deposites->orderBy('id','DESC')->with('user')->paginate(7);
        
        $data['users']=$users;
        $data['deposites']=$deposites;

        return View('admin.deposite.create',$data);
    }
    public function store(Request $request){
        $validator =Validator::make($request->all(),[
            'name'=>'requied',
            'amount'=>'required',
            'date'=>'required'
        ]);
        if($validator->passes()){
            $deposites =new Deposite();
            $deposites->user_id=$request->user;
            $deposites->amount=$request->amount;
            $deposites->date=$request->date;
            $deposites->save();
            $message='Money Deposite successfully';
            session()->flash('success',$message);
            return response()->json([
                'status'=>true,
                'message'=>$message
            ]);

        }else{
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()
            ]);
        }
        
    }
    public function destroy($id ){
        $deposites =Deposite::find($id);
        
        if (empty($deposites)) {
            $message='Deposite record not found';
            session()->flash('error',$message);
            return response()->json([
                'status'=>false,
                'message'=>$message
            ]);
        }
        $deposites->delete();
        $message='Deposite record deleted successfully';
        session()->flash('success',$message);
        return response()->json([
            'status'=>true,
            'message'=>$message
        ]);
    }
}
