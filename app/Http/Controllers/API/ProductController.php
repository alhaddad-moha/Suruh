<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ResponseHandler;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    use ResponseHandler;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products = ProductResource::collection(Product::all());
        return $this->response($products, "Got All Estates Successfully", 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required|max:255',
            'unit_id' => 'required|max:255',
            'category_id' => 'required|max:255',
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return $this->response(null, "Error: " . $validator->errors()->toJson(), 400);
        }

        try {
            $product = Product::insert([
                'supplier_id' => $request->supplier_id,
                'unit_id' => $request->unit_id,
                'category_id' => $request->category_id,
                'name' => $request->name,
                'created_by' => 1,
                'created_at' => Carbon::now(),
            ]);

            if ($product) {
                return $this->response($product, "Inserted Successfully", 201);
            } else {
                return $this->response(null, "Error", 400);
            }
            // Run your Eloquent query here
        } catch (QueryException $ex) {
            return $this->response(null, "Error: " . $ex->getMessage(), 400);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $product = Product::with('unit')->find($id);
        if (!$product) {
            return $this->response(null, "Not found", 400);

        }
        $product = new ProductResource($product);
        return $this->response($product, "Got category Successfully", 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return $this->response(null, "Error: " . $validator->errors()->toJson(), 400);
        }
        $product = Product::find($id);

        if (!$product) {
            return $this->response(null, "Not found", 400);
        }
        $product->update($request->all());
        return $this->response(null, "Updated Successfully", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return $this->response(null, "Not found", 400);
        }
        $product->delete();
        return $this->response(null, "Deleted Successfully", 200);
    }
}
