<?php

namespace App\Http\Controllers;

use App\Models\AbsenceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsenceTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Admin');
    }

    public function index()
    {
        $absenceType = AbsenceType::paginate(10);
        return view('absenceType.index', ['absenceType' => $absenceType]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        DB::beginTransaction();
        try {
            AbsenceType::create([
                'name' => $request->name,
            ]);

            DB::commit();
            return redirect()->route('absenceType.index')->with('Success ', "Muffaqaiyatli bajarildi");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function create()
    {
        return view('absenceType.create');
    }

    public function delete(AbsenceType $absenceType)
    {
        DB::beginTransaction();
        try {
            AbsenceType::whereId($absenceType->id)->delete();
            DB::commit();
            return redirect()->route('absenceType.index')->with('success', 'Muvafaqiyatli bajarildi');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function update(Request $request, AbsenceType $absenceType)
    {
        $request->validate([
            'name' => 'required',
        ]);

        DB::beginTransaction();
        try {
            AbsenceType::whereId($absenceType->id)->update([
                'name' => $request->name,
            ]);

            DB::commit();

            return redirect()->route('absenceType.index')->with('success', 'Muffaqiyatli bajarildi');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('error', $th->getMessage());
        }
    }


    public function edit(AbsenceType $absenceType)
    {
        return view('absenceType.edit')->with([
            'absenceType' => $absenceType,
        ]);
    }
}
