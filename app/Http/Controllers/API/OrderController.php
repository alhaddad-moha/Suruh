<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ResponseHandler;
use App\Models\Order;
use App\Models\Estate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class OrderController extends Controller
{
    use ResponseHandler;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $orders = OrderResource::collection(Order::with('carts')->get());
        return $this->response($orders, "Got All Estates Successfully", 200);
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
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return $this->response(null, "Error: " . $validator->errors()->toJson(), 400);
        }

        $order = Order::create($request->all());
        if ($order) {
            return $this->response(null, "Inserted Successfully", 201);
        } else {
            return $this->response(null, "Error", 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $order = new OrderResource(Order::with('carts')->find($id));
        if (!$order) {
            return $this->response(null, "Not found", 400);

        }
        $order = new OrderResource($order);
        return $this->response($order, "Got category Successfully", 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
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
        $order = Order::find($id);

        if (!$order) {
            return $this->response(null, "Not found", 400);
        }
        $order->update($request->all());
        return $this->response(null, "Updated Successfully", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return $this->response(null, "Not found", 400);
        }
        $order->delete();
        return $this->response(null, "Deleted Successfully", 200);
    }
}
