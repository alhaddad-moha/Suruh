<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function allCarts()
    {
        $units = Cart::latest()->get();
        return view('admin.backend.unit.all_units', compact('units'));
    }

    public function deleteCart($id)
    {

        Cart::findorFail($id)->delete();
        $notification = array(
            'message' => 'Cart Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }


    public function addCart()
    {

        $unit = Cart::latest()->get();
        return view('admin.backend.unit.unit_add');
    }

    public function storeCart(Request $request)
    {
        if ($request->category_id == null) {
            $notification = array(
                'message' => 'You did not select any item',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        } else {
            $count_category = count($request->category_id);
            $bill_no = random_int(0, 9999);

            for ($i = 0; $i < $count_category; $i++) {
                $purchase = new Cart();
                $purchase->quantity = $request->amount[$i];
                $purchase->supplier_id = $request->supplier_id[$i];
                $purchase->category_id = $request->category_id[$i];
                $purchase->product_id = $request->product_id[$i];
                $purchase->unit_id = $request->unit_id[$i];
                $purchase->customer_id = 1;
                $purchase->customer_name = $request->customer_name;
                $purchase->bill_no = $bill_no;
                $purchase->created_at = Carbon::now();
                $purchase->save();
            }

            Order::insert([
                'cart_id' => $bill_no,
                'customer_name' => $request->customer_name,
                'user_id' => Auth::user()->id,
                'order_date' => Carbon::now(),
                'status' => 0,
                'created_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Purchase Added',
                'alert-type' => 'success'
            );

            return redirect()->route('agent.all')->with($notification);
        }

    }

    public
    function editCart($id)
    {
        $unit = Cart::findOrFail($id);
        return view('admin.backend.unit.unit_edit', compact('unit'));
    }

    public
    function updateCart(Request $request)
    {

        Cart::findOrFail($request->id)->update([
            'name' => $request->name,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);


        $notification = array(
            'message' => 'Cart Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('cart.all')->with($notification);
    }


}
