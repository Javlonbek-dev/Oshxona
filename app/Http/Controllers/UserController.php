<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Exports\UsersImport;
use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Excel;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store', 'updateStatus']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['delete']]);
    }

    public function index()
    {
        $users = User::with('roles')->orderBy('id', 'ASC')->paginate(10);
        return view('users.index', ['users' => $users]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
        ]);

        $employee = Employee::find($data['employee_id']);

        DB::beginTransaction();
        try {
            // Store Data
            $user = User::create([
                'first_name' => $employee->first_name,
                'last_name' => $employee->last_name,
                'email' => $data['email'],
                'mobile_number' => $employee->mobile_number,
                'department_id' => $employee->department_id,
                'role_id' => 2,
                'status' => 1,
                'password' => Hash::make($data['password'])
            ]);

            DB::table('model_has_roles')->where('model_id', $user->id)->delete();

            // Assign Role To User
            $user->assignRole($user->role_id);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('users.index')->with('success', 'Muvaffaqiyatli bajarildi.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function create()
    {
        $departments = Department::all();

        return view('users.add', ['departments' => $departments]);
    }

    public function delete(User $user)
    {
        DB::beginTransaction();
        try {
            // Delete User
            User::whereId($user->id)->delete();

            DB::commit();
            return redirect()->route('users.index')->with('success', 'Muvaffaqiyatli bajarildi!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function updateStatus($user_id, $status)
    {
        // Validation
        $validate = Validator::make([
            'user_id' => $user_id,
            'status' => $status
        ], [
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:0,1',
        ]);

        // If Validations Fails
        if ($validate->fails()) {
            return redirect()->route('users.index')->with('error', $validate->errors()->first());
        }

        try {
            DB::beginTransaction();

            // Update Status
            User::whereId($user_id)->update(['status' => $status]);

            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('users.index')->with('success', 'Muvaffaqiyatli bajarildi!');
        } catch (\Throwable $th) {
            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function update(Request $request, User $user)
    {
        // Validations
        $data = $request->validate([
            'password' => 'required',
            'email' => 'required|unique:users,email,' . $user->id . ',id',
        ]);

        DB::beginTransaction();
        try {
            // Store Data
            User::whereId($user->id)->update([
                'password' => Hash::make($data['password']),
                'email' => $data['email'],
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('users.index')->with('success', 'Muvaffaqiyatli bajarildi.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function edit(User $user)
    {
        return view('users.edit')->with([
            'user' => $user
        ]);
    }

    public function importUsers()
    {
        return view('users.import');
    }

    public function uploadUsers(Request $request)
    {
        Excel::import(new UsersImport(), $request->file);

        return redirect()->route('users.index')->with('success', 'Muvaffaqiyatli bajarildi');
    }

    public function export()
    {
        return Excel::download(new UsersExport(), 'users.xlsx');
    }

}
