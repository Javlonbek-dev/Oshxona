<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PositionController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth');
//        $this->middleware('role:Admin');
    }

    public function index()
    {
        $positions = Position::paginate(10);
        return view('positions.index', ['positions' => $positions]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        DB::beginTransaction();
        try {
            Position::create([
                'name' => $request->name,
            ]);

            DB::commit();
            return redirect()->route('positions.index')->with('success', 'Muvaffaqiyatli bajarildi.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function create()
    {
        return view('positions.add');
    }

    public function delete(Position $position)
    {
        DB::beginTransaction();
        try {
            Position::whereId($position->id)->delete();

            DB::commit();
            return redirect()->route('positions.index')->with('success', 'Muvaffaqiyatli bajarildi!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function update(Request $request, Position $position)
    {
        $request->validate([
            'name' => 'required',
        ]);

        DB::beginTransaction();
        try {
            Position::whereId($position->id)->update([
                'name' => $request->name,
            ]);

            DB::commit();
            return redirect()->route('positions.index')->with('success', 'Muvaffaqiyatli bajarildi.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function edit(Position $position)
    {
        return view('positions.edit')->with([
            'position' => $position
        ]);
    }

}
