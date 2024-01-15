<?php

namespace App\Http\Controllers\admin;

use App\Models\Meal;
use App\Models\User;
use App\Models\Deposite;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    public function index()
    {
        //this month total cost
        $startMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $currenDate = Carbon::now()->format('Y-m-d');
        $toatlcostthisMonth = Deposite::whereDate('created_at', '>=', $startMonth)->whereDate('created_at', '<=', $currenDate)->sum('amount');
        //total meal
        $morningMeal = Meal::whereDate('created_at', '>=', $startMonth)->whereDate('created_at', '<=', $currenDate)->sum('moring_meal');
        $lunchmeal = Meal::whereDate('created_at', '>=', $startMonth)->whereDate('created_at', '<=', $currenDate)->sum('lunch_meal');
        $dinnerMeal = Meal::whereDate('created_at', '>=', $startMonth)->whereDate('created_at', '<=', $currenDate)->sum('dinner_meal');
        $totalMeals = $morningMeal + $lunchmeal + $dinnerMeal;
        //totalmessMemer       
        $totalmessmeMber = User::where('role', 0)->count();
        //mealRate
        $mealRate = $toatlcostthisMonth / $totalMeals;
        return View('admin.dashboard', [
            'toatlcostthisMonth' => $toatlcostthisMonth,
            'totalMeals' => $totalMeals,
            'totalmessmeMber' => $totalmessmeMber,
            'mealRate' => $mealRate,
        ]);
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
    public function details()
    {

        //last month total sale 
        $lastMonthStartDate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
        $lastMonthendingDate = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
        //individual deposite count
        $users = User::orderBy('name', 'ASC')->where('role', 0)->get();
        $userIds = $users->pluck('id')->toArray();

        $userSums = User::leftJoin(
            DB::raw('(SELECT user_id, SUM(amount) as total_amount 
        FROM deposites 
        WHERE created_at >= ? 
        AND created_at <= ? 
        GROUP BY user_id) AS deposit_sums'),
            'users.id',
            '=',
            'deposit_sums.user_id'
        )
            ->select('users.id as user_id', 'users.name', DB::raw('COALESCE(deposit_sums.total_amount, 0) as total_amount'))
            ->where('users.role', '=', 0)  // Add this condition to filter users with role=0
            ->where('users.id', '!=', null)
            ->addBinding($lastMonthStartDate, 'select')
            ->addBinding($lastMonthendingDate, 'select')
            ->orderBy('users.id')
            ->get();
        $usermeals = Meal::whereDate('created_at', '>=', $lastMonthStartDate)->whereDate('created_at', '<=', $lastMonthendingDate)->whereIn('user_id', $userIds)
            ->groupBy('user_id')->selectRaw('user_id, sum(moring_meal) as moring_sum, sum(lunch_meal) as lunch_sum, sum(dinner_meal) as dinner_sum')->get();
        //  dd($usermeals);
        //meal rate and meal total tk count
        $totalamountlastmonth = Deposite::whereDate('created_at', '>=', $lastMonthStartDate)->whereDate('created_at', '<=', $lastMonthendingDate)
            ->sum('amount');
        // dd($totalamountlastmonth);
        //total meal
        $morningMeal = Meal::whereDate('created_at', '>=', $lastMonthStartDate)->whereDate('created_at', '<=', $lastMonthendingDate)->sum('moring_meal');
        $lunchmeal = Meal::whereDate('created_at', '>=', $lastMonthStartDate)->whereDate('created_at', '<=', $lastMonthendingDate)->sum('lunch_meal');
        $dinnerMeal = Meal::whereDate('created_at', '>=', $lastMonthStartDate)->whereDate('created_at', '<=', $lastMonthendingDate)->sum('dinner_meal');
        $totalMeals = $morningMeal + $lunchmeal + $dinnerMeal;
        //dd($totalMeals);
        $lastmonthmealtrate = $totalamountlastmonth / $totalMeals;

        $data = [];
        $data['userSums'] = $userSums;
        $data['users'] = $users;
        $data['usermeals'] = $usermeals;
        $data['lastmonthmealtrate'] = $lastmonthmealtrate;
        $data['users'] = $users;
        return View('admin.deposite.individual-list', $data);
    }
}
