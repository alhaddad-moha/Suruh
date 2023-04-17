<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Approve;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function allProducts()
    {
        $products = Product::latest()->get();
        $supplier = Supplier::latest()->get();
        $unit = Unit::latest()->get();
        return view('admin.backend.product.all_product', compact('products'));
    }

    public function agentInvoice()
    {

        $suppliers = Supplier::all();
        $categories = Category::all();
        $units = Unit::all();
        $products = Product::latest()->get();
        return view('admin.backend.agent.agent_add', compact('suppliers', 'categories', 'units', 'products'));
    }

    public function allInvoice()
    {
        $orders = Order::all();
        $approves = Approve::all();
        return view('admin.backend.agent.all_order', compact('orders', 'approves'));
    }

    public function storeInvoice(Request $request)
    {
        $name = '';
        foreach ($request->addMoreInputFields as $key => $value) {

            return $value;
            /* Cart::insert([
                 'product_id' => $request->product,
                 'supplier_id' => $request->supplier,
                 'unit_id' => $request->unit,
                 'category_id' => $request->category,
                 'customer_id' =>1,
                 'quantity' => 1,
                 'created_by' => Auth::user()->id,
                 'created_at' => Carbon::now(),

             ]);*/

            echo $key;
            echo "Moha";

        }

        return response($request->addMoreInputFields[1]['unit']);

        $notification = array(
            'message' => 'Product Added Successfully',
            'alert-type' => 'success'
        );
        //  return redirect()->route('product.all')->with($notification);
        // return $request->addMoreInputFields;
        // return $name;


    }


    public function deleteProduct($id)
    {

        Product::findorFail($id)->delete();
        $notification = array(
            'message' => 'Product Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }


    public function addProduct()
    {

        $suppliers = Supplier::all();
        $categories = Category::all();
        $units = Unit::all();
        $products = Product::latest()->get();
        return view('admin.backend.product.product_add', compact('suppliers', 'categories', 'units'));
    }

    public function storeProduct(Request $request)
    {
        Product::insert([
            'supplier_id' => $request->supplier_id,
            'unit_id' => $request->unit_id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Product Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('product.all')->with($notification);
    }

    public
    function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $suppliers = Supplier::all();
        $categories = Category::all();
        $units = Unit::all();
        return view('admin.backend.product.product_edit', compact('suppliers', 'categories', 'units', 'product'));
    }

    public
    function updateProduct(Request $request)
    {

        Product::find($request->id)->update([
            'supplier_id' => $request->supplier_id,
            'unit_id' => $request->unit_id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);


        $notification = array(
            'message' => 'Product Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('product.all')->with($notification);
    }


}
