<?php

namespace App\Http\Controllers\front;

use App\Models\Meal;
use App\Models\User;
use App\Models\Deposite;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        return View('front.account.login');
    }
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->passes()) {
            if (Auth::guard('member')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
                $admin = Auth::guard('member')->user();
                if ($admin->role == 0) {
                    return redirect()->route('account.profile');
                } else {
                    Auth::guard('member')->logout();
                    return redirect()->route('account.login')->with('error', 'You are not authorized to access admin pannel');
                }
            } else {
                return redirect()->route('account.login')->with('error', 'Email or Password is incorrect');
            }
        } else {
            return redirect()->route('account.login')->withErrors($validator)->withInput($request->only('email'));
        }
    }
    public function profile()
    {
        //last month total cost
        $startLastMonth = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
        $endLastMonth = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
        $toatlcostthisMonth = Deposite::whereDate('created_at', '>=', $startLastMonth)->whereDate('created_at', '<=', $endLastMonth)->sum('amount');
        //total meal
        $totalMeals = Meal::whereBetween('created_at', [$startLastMonth, $endLastMonth])
            ->selectRaw('SUM(moring_meal + lunch_meal + dinner_meal) as total_meals')
            ->first()
            ->total_meals;
        //totalmessMemer       
        $totalmessmeMber = User::where('role', 0)->count();
        //mealRate
        $mealRate = $toatlcostthisMonth / $totalMeals;
        //last month count 
        $lastMonthStartDate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
        $lastMonthendingDate = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
        $user = Auth::guard('member')->user()->id;
        $totalAmountLastMonth = Deposite::where('user_id', $user)->where('created_at', '>=', $lastMonthStartDate)->whereDate('created_at', '<=', $lastMonthendingDate)->sum('amount');
        // total meal count last month
        $totalLastMonthMeals = Meal::where('user_id', $user)->whereBetween('created_at', [$startLastMonth, $endLastMonth])
            ->selectRaw('SUM(moring_meal + lunch_meal + dinner_meal) as total_meals')
            ->first()->total_meals;
        //total cost calculate
        $lastMonthMealCost = $mealRate * $totalLastMonthMeals;
        $due = $totalAmountLastMonth - $lastMonthMealCost;
        $users = Auth::guard('member')->user();
        return View('front.account.index', [
            'toatlcostthisMonth' => $toatlcostthisMonth,
            'totalMeals' => $totalMeals,
            'totalmessmeMber' => $totalmessmeMber,
            'mealRate' => $mealRate,
            'totalAmountLastMonth' => $totalAmountLastMonth,
            'totalLastMonthMeals' => $totalLastMonthMeals,
            'lastMonthMealCost' => $lastMonthMealCost,
            'due' => $due,
            'users' => $users,
        ]);
    }
    public function meals(){
        $user = Auth::guard('member')->user()->id;
        $lastmonthstarting=Carbon::now()->subMonths()->startOfMonth()->format('Y-m-d');
        $lastMonthEnding=Carbon::now()->subMonths()->endOfMonth()->format('Y-m-d');
        $mealss=Meal::where('user_id',$user)->where('created_at','>=',$lastmonthstarting)->whereDate('created_at','<=',$lastMonthEnding);
        $totalLastMonthMeals = Meal::where('user_id', $user)->whereBetween('created_at', [$lastmonthstarting, $lastMonthEnding])
        ->selectRaw('SUM(moring_meal + lunch_meal + dinner_meal) as total_meals')
        ->first()->total_meals;
        $meal=$mealss->paginate(10);
        return View('front.account.lastMonthTotalMeals',[
            'meal'=>$meal,
            'totalLastMonthMeals'=>$totalLastMonthMeals,
        ]);
    }
    public function deposite(){
      $user=Auth::guard('member')->user()->id;
      $lastmonthstarting=Carbon::now()->subMonths()->startOfMonth()->format('Y-m-d');
      $lastMonthEnding=Carbon::now()->subMonths()->endOfMonth()->format('Y-m-d');
      $depostie=Deposite::where('user_id',$user)->where('created_at','>=',$lastmonthstarting)->whereDate('created_at','<=',$lastMonthEnding);
      $deposite=$depostie->paginate(10);
      $totalDeposite=Deposite::where('user_id',$user)->where('created_at','>=',$lastmonthstarting)->whereDate('created_at','<=',$lastMonthEnding)->sum('amount');

      return View('front.account.lastMonthDepositeDetails',[
        'deposite'=>$deposite,
        'totalDeposite'=>$totalDeposite,
      ]);

    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login')->with('success', 'You successfully logged out.');
    }
}


