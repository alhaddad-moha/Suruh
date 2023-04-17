<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Http\Resources\ProductResource;
use App\Models\Approve;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{

    public function printOrder($id)
    {
        $order = Order::findOrFail($id);
        $carts = Cart::where('bill_no', $order->cart_id)->get();
        $approve = Approve::where('bill_no', $order->cart_id)->get();
        $data = [$order, $carts];
        // return view('admin.backend.pdf.order_pdf', compact('order', 'carts'));

        return view('admin.backend.pdf.order_pdf', compact('order', 'carts', 'approve'));
    }

    public function printOrderNow($id)
    {

    }

    public function acceptOrder($id)
    {

        $order = Order::with('customer')->findOrFail($id);
        $carts = Cart::with('product')->where('order_id', $order->id)->get();
        $carts = CartResource::collection($carts);
        $units = Unit::all();
        $categories = Category::all();
        $suppliers = Supplier::all();

        return view('admin.backend.agent.order_accept', compact('order', 'carts', 'units', 'categories', 'suppliers'));
        /*        return view('admin.backend.agent.invoice_details');*/
    }

    public function updateOrder()
    {

        $order_id = Session::get('order_id');
        Order::findOrFail($order_id)->update([
            'status' => 1,
            'updated_at' => Carbon::now(),
        ]);


        $notes = Session::get('notes');
        Approve::insert([
            'device_id' => '11',
            'ip_address' => request()->ip(),
            'confirmed_at' => Carbon::now(),
            'bill_no' => $order_id,
            'notes' => $notes,
        ]);

        return redirect()->route('order.thanks');
    }

    public function thanks()
    {
        return view('admin.backend.agent.thanks');
    }

    public function verifyCustomer($id, Request $request)
    {
        $customer = Customer::find($id);
        $notes = $request->notes;
        Session::put('order_id', $request->order_id);
        Session::put('notes', $request->notes);

        return view('admin.verify', compact('customer', 'notes'));
    }
}
