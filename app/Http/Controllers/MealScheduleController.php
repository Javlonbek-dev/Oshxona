<?php

namespace App\Http\Controllers;
use App\Models\Meal;
use App\Models\MealSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class MealScheduleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Admin');
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
                ->paginate(5);

            $days[] = [
                'date' => $date,
                'meals' => $meals,
            ];
        }

        $days = new LengthAwarePaginator($days, count($days), 5);

        return view('mealschedule.index', compact('selectedDate', 'days', 'weeks'));
    }

    public function create()
    {
        $meals = Meal::all();
        $selectedDate = request('selectedDate');
        $meal_schedules = MealSchedule::with('meal')->where('date', request('selectedDate'))->pluck('meal_id');

        return view('mealschedule.add', compact('meal_schedules', 'selectedDate', 'meals'));
    }


    public function store(Request $request)
    {
        $date = $request->input('date');
        $selectedMeals = $request->input('meals') ?? [];

        MealSchedule::where('date', $date)->delete();

        foreach ($selectedMeals as $mealId) {
            MealSchedule::create([
                'meal_id' => $mealId,
                'date' => $date,
            ]);
        }

        return redirect()->route('mealschedule.index')->with('success', 'Muvaffaqiyatli bajarildi.');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
