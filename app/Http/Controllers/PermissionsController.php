<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:permission-list|permission-create|permission-edit|permission-delete', ['only' => ['index']]);
        $this->middleware('permission:permission-create', ['only' => ['create','store']]);
        $this->middleware('permission:permission-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $permissions = Permission::paginate(10);

        return view('permissions.index', [
            'permissions' => $permissions
        ]);
    }


    public function create()
    {
        return view('permissions.add');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required',
                'guard_name' => 'required'
            ]);

            Permission::create($request->all());

            DB::commit();
            return redirect()->route('permissions.index')->with('success','Permissions created successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('permissions.add')->with('error',$th->getMessage());
        }

    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $permission = Permission::whereId($id)->first();

        return view('permissions.edit', ['permission' => $permission]);
    }


    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required',
                'guard_name' => 'required'
            ]);

            $permission = Permission::whereId($id)->first();

            $permission->name = $request->name;
            $permission->guard_name = $request->guard_name;
            $permission->save();


            DB::commit();
            return redirect()->route('permissions.index')->with('success','Permissions updated successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('permissions.edit',['permission' => $permission])->with('error',$th->getMessage());
        }
    }


    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            Permission::whereId($id)->delete();

            DB::commit();
            return redirect()->route('permissions.index')->with('success','Permissions deleted successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('permissions.index')->with('error',$th->getMessage());
        }
    }
}
