<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;

class CustomerController extends Controller
{
    public function allCustomers()
    {
//        $suppliers= Supplier::all();
        $customers = Customer::latest()->get();
        return view('admin.backend.customer.all_customers', compact('customers'));
    }


    public function addCustomer()
    {

        return view('admin.backend.customer.customer_add');
    }

    public function storeCustomer(Request $request)
    {
        $image = $request->file('customer_image');
        $imgType = $image->getClientOriginalExtension();
        $generatedName = hexdec(uniqid()) . '.' . $imgType;
        echo $image->getClientOriginalExtension();
        Image::make($image)->resize(200, 200)->save('upload/customer/' . $generatedName);
        $imgUrl = 'upload/customer/' . $generatedName;
        Customer::insert([
            'name' => $request->name,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
            ]);

        $notification = array(
            'message' => 'Customer Added Successfully' . 'path = ' . $image->getClientOriginalExtension(),
            'alert-type' => 'success'
        );

        return redirect()->route('customer.all')->with($notification);
    }


    public
    function editCustomer($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.backend.customer.customer_edit', compact('customer'));
    }

    public
    function updateCustomer(Request $request)
    {
        if ($request->file('customer_image' != null)) {

            $image = $request->file('customer_image');
            $imgType = $image->getClientOriginalExtension();
            $generatedName = hexdec(uniqid()) . '.' . $imgType;
            echo $image->getClientOriginalExtension();
            Image::make($image)->resize(200, 200)->save('upload/customer/' . $generatedName);
            $imgUrl = 'upload/customer/' . $generatedName;
            Customer::findOrFail($request->id)->update([
                'name' => $request->name,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Customer Updated Successfully with Image',
                'alert-type' => 'success'
            );
            return redirect()->route('customer.all')->with($notification);


        } else {
            Customer::findOrFail($request->id)->update([
                'name' => $request->name,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Customer Updated Successfully Without Image',
                'alert-type' => 'success'
            );
            return redirect()->route('customer.all')->with($notification);

        }


    }

    public function deleteCustomer($id)
    {
        $customer = Customer::findorFail($id);
        $img = $customer->customer_image;
        unlink($img);
        Customer::findorFail($id)->delete();
        $notification = array(
            'message' => 'Customer Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }


}
