<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUnitRequest;
use App\Http\Resources\UnitResource;
use App\Http\Resources\ResponseHandler;
use App\Models\Unit;
use App\Models\Estate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class UnitController extends Controller
{
    use ResponseHandler;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories = UnitResource::collection(Unit::all());
        return $this->response($categories, "Got All Estates Successfully", 200);
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

        $unit = Unit::create([
            "name" => $request->name,
            "created_by" => 1,
        ]);
        if ($unit) {
            return $this->response(null, "Inserted Successfully", 201);
        } else {
            return $this->response(null, "Error", 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Unit $unit
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $unit = Unit::find($id);
        if (!$unit) {
            return $this->response(null, "Not found", 400);

        }
        $unit = new UnitResource($unit);
        return $this->response($unit, "Got category Successfully", 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Unit $unit
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
        $unit = Unit::find($id);

        if (!$unit) {
            return $this->response(null, "Not found", 400);
        }
        $unit->update($request->all());
        return $this->response(null, "Updated Successfully", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Unit $unit
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $unit = Unit::find($id);
        if (!$unit) {
            return $this->response(null, "Not found", 400);
        }
        $unit->delete();
        return $this->response(null, "Deleted Successfully", 200);
    }
}
