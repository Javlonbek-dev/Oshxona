<?php

namespace App\Http\Controllers;

use App\Models\MealSchedule;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function index()
    {
        $selectedDate = request('selectedDate') ? Carbon::parse(request('selectedDate')) : now();

        $startDate = $selectedDate->startOfWeek();

        $weeks = [];
        for ($i = 0; $i < 7; $i++) {
            $weeks[] = $startDate->copy()->addDays($i);
        }

        $days = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i)->format('Y-m-d');

            $meals = MealSchedule::where('date', $date)
                ->with([
                    'meal' => function ($query) {
                        $query->select('id', 'name', 'photo');
                    }
                ])
                ->with('shift')
                ->get();

            $days[] = [
                'date' => $date,
                'meals' => $meals,
            ];
        }
//        $days = new LengthAwarePaginator($days, count($days), 5);

//        return view('dashboard', compact('selectedDate', 'days', 'weeks'));
        return view('auth.login', compact('selectedDate', 'days', 'weeks'));
    }
}
