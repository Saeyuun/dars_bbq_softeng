<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\InventoryResource;
use Illuminate\Http\Request;
use App\Models\Inventory;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    public function index()
    {
        $employee = Inventory::get();
        if($employee->count() > 0) {
            return InventoryResource::collection($employee);
        }
    }
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'quantity' => 'required',
            'status' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validate->errors()
            ], 422); // Use 422 Unprocessable Entity for validation errors
        }

        $employee = Inventory::create($validate->validated());

        return response()->json([
            'message' => 'Product created successfully',
            'data' => new InventoryResource($employee)
        ], 201); // Use 201 Created for successful resource creation
    }

    public function show(Inventory $inventory)
    {
        return new InventoryResource($inventory);
    }

    public function update(Request $request, Inventory $inventory)
    {
        $validate = Validator::make($request->all(), [
            'quantity' => 'required',
            'status' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validate->errors()
            ], 422); // Use 422 Unprocessable Entity for validation errors
        }

        $employee = Inventory::update($validate->validated());

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => new InventoryResource($inventory)
        ]);
    }


    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return response()->json([
            'message' => 'Inventory data successfully deleted'
        ]);
    }
}
