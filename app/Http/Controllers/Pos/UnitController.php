<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{
    public function allUnits()
    {
        $units = Unit::latest()->get();
        return view('admin.backend.unit.all_units', compact('units'));
    }

    public function deleteUnit($id)
    {

        Unit::findorFail($id)->delete();
        $notification = array(
            'message' => 'Unit Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }


    public function addUnit()
    {

        $unit = Unit::latest()->get();
        return view('admin.backend.unit.unit_add');
    }

    public function storeUnit(Request $request)
    {
        Unit::insert([
            'name' => $request->name,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Unit Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('unit.all')->with($notification);
    }

    public
    function editUnit($id)
    {
        $unit = Unit::findOrFail($id);
        return view('admin.backend.unit.unit_edit', compact('unit'));
    }

    public
    function updateUnit(Request $request)
    {

        Unit::findOrFail($request->id)->update([
            'name' => $request->name,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);


        $notification = array(
            'message' => 'Unit Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('unit.all')->with($notification);
    }


}
