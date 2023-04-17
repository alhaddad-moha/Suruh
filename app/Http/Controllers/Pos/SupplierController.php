<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    public function allSuppliers()
    {
//        $suppliers= Supplier::all();
        $suppliers = Supplier::all();
        return view('admin.backend.supplier.all_suppliers', compact('suppliers'));
    }

    public function deleteSupplier($id)
    {

        Supplier::findorFail($id)->delete();
        $notification = array(
            'message' => 'Supplier Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }


    public function addSupplier()
    {

        $suppliers = Supplier::latest()->get();
        return view('admin.backend.supplier.supplier_add');
    }

    public function storeSupplier(Request $request)
    {
        Supplier::insert([
            'name' => $request->name,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Supplier Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('supplier.all')->with($notification);
    }

    public
    function editSupplier($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('admin.backend.supplier.supplier_edit', compact('supplier'));
    }

    public
    function updateSupplier(Request $request)
    {

        Supplier::findOrFail($request->id)->update([
            'name' => $request->name,
            'mobile_number' => $request->mobile_number,
            'email' => $request->email,
            'address' => $request->address,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);


        $notification = array(
            'message' => 'Supplier Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('supplier.all')->with($notification);
    }


}
