<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUnitRequest;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\UnitResource;
use App\Http\Resources\ResponseHandler;
use App\Models\Customer;
use App\Models\Unit;
use App\Models\Estate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CustomerController extends Controller
{
    use ResponseHandler;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $customers = CustomerResource::collection(Customer::all());
        return $this->response($customers, "Got All Estates Successfully", 200);
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
            'mobile_number' => 'required|max:15',
        ]);

        if ($validator->fails()) {
            return $this->response(null, "Error: " . $validator->errors()->toJson(), 400);
        }

        $customer = Customer::create([
            "name" => $request->name,
            "mobile_number" => $request->mobile_number,
            "created_by" => 1,
        ]);
        if ($customer) {
            return $this->response(null, "Inserted Successfully", 201);
        } else {
            return $this->response(null, "Error", 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return $this->response(null, "Not found", 400);
        }
        $customer = new CustomerResource($customer);
        return $this->response($customer, "Got category Successfully", 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'mobile_number' => 'required|max:15',
        ]);
        if ($validator->fails()) {
            return $this->response(null, "Error: " . $validator->errors()->toJson(), 400);
        }
        $customer = Customer::find($id);

        if (!$customer) {
            return $this->response(null, "Not found", 400);
        }
        $customer->update($request->all());
        return $this->response(null, "Updated Successfully", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return $this->response(null, "Not found", 400);
        }
        $customer->delete();
        return $this->response(null, "Deleted Successfully", 200);
    }
}

