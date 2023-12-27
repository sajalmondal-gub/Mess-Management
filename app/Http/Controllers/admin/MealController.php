<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class MealController extends Controller
{
    public function index()
    {
        $data = [];
        $users = User::orderBy('name', 'ASC')->where('role', 0)->get();
        $meals = Meal::orderBy('id', 'DESC')->with('user')->paginate(10);
        $data['meals'] = $meals;
        $data['users'] = $users;
        return View('admin.meal.list', $data);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user' => 'required',
            'date' => 'required'
        ]);
        if ($validator->passes()) {
            $id = $request->user;
            $formattedDate = date('Y-m-d', strtotime($request->date));
            $existingRecord = Meal::where('user_id', $id)
                ->where('date', $formattedDate)->first();
            if ($existingRecord) {
                Meal::where('user_id', $id)->update([
                    'user_id' => $request->user,
                    'date' => $request->date,
                    'moring_meal' => $request->morning_meal,
                    'lunch_meal' => $request->lunch_meal,
                    'dinner_meal' => $request->dinner_meal
                ]);
                $message = 'Meal add successfully';
                session()->flash('success', $message);
                return response()->json([
                    'status' => true,
                    'message' => $message
                ]);
            } else {
                $meals = new Meal();
                $meals->user_id = $request->user;
                $meals->date = $request->date;
                $meals->moring_meal = $request->morning_meal;
                $meals->lunch_meal = $request->lunch_meal;
                $meals->dinner_meal = $request->dinner_meal;
                $meals->save();
                $message = 'Meal add successfully';
                session()->flash('success', $message);
                return response()->json([
                    'status' => true,
                    'message' => $message
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function destroy($id){
        $meal =Meal::find($id);
        if($meal==null){
            $message=' Meal Records not found';
            session()->flash('error',$message);
            return response()->json([
                'status'=>false,
                'message'=>$message
            ]);
        }
        $meal->delete();
        $message='Meal record deleted successfully';
        session()->flash('success',$message);
        return response()->json([
            'status'=>true,
            'message'=>$message
        ]);
    
    }
    
}
