<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShiftController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Admin');
    }

    public function index()
    {
        $shifts = Shift::paginate(10);
        return view('shifts.index', ['shifts' => $shifts]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'begin_date' => 'required',
            'end_date' => 'required',
            'description' => 'nullable',
        ]);

        DB::beginTransaction();
        try {
            Shift::create([
                'name' => $request->name,
                'begin_date' => $request->begin_date,
                'end_date' => $request->end_date,
                'description' => $request->description,
            ]);

            DB::commit();
            return redirect()->route('shifts.index')->with('success', 'Muvaffaqiyatli bajarildi.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function create()
    {
        return view('shifts.add');
    }

    public function delete(Shift $shift)
    {
        DB::beginTransaction();
        try {
            Shift::whereId($shift->id)->delete();

            DB::commit();
            return redirect()->route('shifts.index')->with('success', 'Muvaffaqiyatli bajarildi!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function update(Request $request, Shift $shift)
    {
        $request->validate([
            'name' => 'required',
            'begin_date' => 'required',
            'end_date' => 'required',
            'description' => 'nullable',
        ]);

        DB::beginTransaction();
        try {
            Shift::whereId($shift->id)->update([
                'name' => $request->name,
                'begin_date' => $request->begin_date,
                'end_date' => $request->end_date,
                'description' => $request->description,
            ]);

            DB::commit();
            return redirect()->route('shifts.index')->with('success', 'Muvaffaqiyatli bajarildi.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function edit(Shift $shift)
    {
        return view('shifts.edit')->with([
            'shift' => $shift
        ]);
    }
}
