<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Admin');
    }

    public function index()
    {
        $rows = request('rows') ?? 25;
        $employees = Employee::query();

        $search = request('search') ?? null;
        if ($search) {
            $employees->where(function ($query) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%');
                $query->orWhere('last_name', 'like', '%' . $search . '%');
                $query->orWhere('middle_name', 'like', '%' . $search . '%');
                $query->orWhere('tabel', $search);
                $query->orWhere('pnfl', $search);
                $query->orWhere('mobile_number', 'like', '%' . $search . '%');
            });
        }

        $departmentId = request('department_id') ?? null;
        if ($departmentId) {
            $employees->where('department_id', $departmentId);
        }

        $departments = Department::all();
        $employees = $employees->paginate($rows);

        return view('employees.index', [
            'rows' => $rows,
            'employees' => $employees,
            'departmentId' => $departmentId,
            'search' => $search,
            'departments' => $departments,
        ]);
    }

    public function getList()
    {
        $departmentId = request('department_id');
        $employees = Employee::query();
        if ($departmentId) {
            $employees->where('department_id', $departmentId);
        }
        return EmployeeResource::collection($employees->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'nullable',
            'tabel' => 'required',
            'mobile_number' => 'nullable',
            'pnfl' => 'nullable',
            'department_id' => 'required',
            'position_id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            Employee::create($data);

            DB::commit();
            return redirect()->route('employees.index')->with('success', 'Muvaffaqiyatli bajarildi.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function create()
    {
        $departments = Department::all();
        $positions = Position::all();
        return view('employees.add', ['departments' => $departments, 'positions' => $positions]);
    }

    public function delete(Employee $employee)
    {
        DB::beginTransaction();
        try {
            Employee::whereId($employee->id)->delete();

            DB::commit();
            return redirect()->route('employees.index')->with('success', 'Muvaffaqiyatli bajarildi!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'nullable',
            'tabel' => 'required',
            'mobile_number' => 'nullable',
            'pnfl' => 'nullable',
            'department_id' => 'required',
            'position_id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            Employee::whereId($employee->id)->update($data);

            DB::commit();
            return redirect()->route('employees.index')->with('success', 'Muvaffaqiyatli bajarildi.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function edit(Employee $employee)
    {
        $departments = Department::all();
        $positions = Position::all();
        return view('employees.edit')->with([
            'employee' => $employee,
            'departments' => $departments,
            'positions' => $positions
        ]);
    }

}
