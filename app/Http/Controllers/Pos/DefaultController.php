<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class DefaultController extends Controller
{
    public function getCategory(Request $request)
    {
        $supplier_id = $request->supplier_id;
        $allCategories = Product::with(['category'])->select('category_id')->where('supplier_id', $supplier_id)
            ->groupBy('category_id')->get();

        return response()->json($allCategories);
    }

    public function getProducts(Request $request)
    {
        $category_id = $request->category_id;
        $allProducts = Product::where('category_id', $category_id)->get();

        return response()->json($allProducts);
    }

}
