<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth');
//        $this->middleware('role:Admin');
    }

    public function index()
    {
        $departments = Department::paginate(10);
        return view('departments.index', ['departments' => $departments]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'nullable',
            'name' => 'required',
        ]);

        DB::beginTransaction();
        try {
            Department::create([
                'code' => $request->code,
                'name' => $request->name,
            ]);

            DB::commit();
            return redirect()->route('departments.index')->with('success', 'Muvofaqqiyatli bajarildi.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function create()
    {
        return view('departments.add');
    }

    public function delete(Department $department)
    {
        DB::beginTransaction();
        try {
            Department::whereId($department->id)->delete();

            DB::commit();
            return redirect()->route('departments.index')->with('success', 'Muvaffaqiyatli bajarildi!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'code' => 'nullable',
            'name' => 'required',
        ]);

        DB::beginTransaction();
        try {
            Department::whereId($department->id)->update([
                'code' => $request->code,
                'name' => $request->name,
            ]);

            DB::commit();
            return redirect()->route('departments.index')->with('success', 'Muvaffaqiyatli bajarildi.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function edit(Department $department)
    {
        return view('departments.edit')->with([
            'department' => $department
        ]);
    }

}
