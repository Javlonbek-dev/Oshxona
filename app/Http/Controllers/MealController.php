<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MealController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Admin');
    }

    public function index()
    {
        $meals = Meal::paginate(10);
        return view('meals.index', ['meals' => $meals]);
    }

    public function create()
    {
        return view('meals.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $meal = Meal::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            if ($request->hasFile('photo')) {
                $generatedFileName = Str::uuid() . '.' . $request->file('photo')->getClientOriginalExtension();

                $request->file('photo')->storeAs('public/meals/photos', $generatedFileName);
                $meal->photo = $generatedFileName;

                $meal->save();
            }

            DB::commit();
            return redirect()->route('meals.index')->with('success', 'Muvaffaqiyatli bajarildi.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function show(Meal $meal)
    {
        //
    }

    public function edit(Meal $meal)
    {
        return view('meals.edit')->with([
            'meal' => $meal
        ]);
    }

    public function update(Request $request, Meal $meal)
    {
        $request->validate([
            'name' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $meal->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            if ($request->hasFile('photo')) {
                // Delete the old photo if it exists
                if ($meal->photo) {
                    Storage::delete('public/meals/photos/' . $meal->photo);
                }

                $generatedFileName = Str::uuid() . '.' . $request->file('photo')->getClientOriginalExtension();

                $request->file('photo')->storeAs('public/meals/photos', $generatedFileName);
                $meal->photo = $generatedFileName;
            }

            $meal->save();

            DB::commit();
            return redirect()->route('meals.index')->with('success', 'Muvaffaqiyatli yangilandi.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }


    public function delete(Meal $meal)
    {
        DB::beginTransaction();

        try {
            // Delete the associated photo if it exists
            if ($meal->photo) {
                Storage::delete('public/meals/photos/' . $meal->photo);
            }

            $meal->delete();

            DB::commit();
            return redirect()->route('meals.index')->with('success', 'Muvaffaqiyatli o\'chirildi.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

}
