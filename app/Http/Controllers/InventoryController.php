<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\InventoryResource;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class InventoryController extends Controller
{
    public function index()
    {
        $inventory = Inventory::with('item')->get();
        return Inertia::render('Inventory', [
            'items' => $inventory->map(function ($inv) {
                return [
                    'id' => $inv->item->item_id,
                    'name' => $inv->item->item_name,
                    'status' => $inv->status,
                    'quantity' => $inv->quantity,
                    'description' => $inv->item->description,
                    'dateUpdated' => $inv->updated_at->format('Y-m-d'),
                ];
            })
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string',
            'description' => 'nullable|string',
            'unit' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'status' => 'required|string|in:available,out_of_stock',
            'employee_id' => 'required|exists:employee,employee_id'
        ]);

        try {
            DB::beginTransaction();

            // Create the item first
            $item = Item::create([
                'item_name' => $request->item_name,
                'description' => $request->description,
                'unit' => $request->unit
            ]);

            Log::info('Item created:', ['item' => $item->toArray()]);

            // Create the inventory record
            $inventory = Inventory::create([
                'item_id' => $item->item_id,
                'employee_id' => $request->employee_id,
                'quantity' => $request->quantity,
                'status' => $request->status
            ]);

            Log::info('Inventory created:', ['inventory' => $inventory->toArray()]);

            DB::commit();

            return redirect()->route('inventory')->with('success', 'Item added successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating item and inventory:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('inventory')->with('error', 'Error creating item: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
            'status' => 'required|string|in:available,out_of_stock',
        ]);

        $inventory->update($request->only(['quantity', 'status']));
        return redirect()->route('inventory')->with('success', 'Item updated successfully');
    }

    public function destroy(Inventory $inventory)
    {
        try {
            DB::beginTransaction();
            
            // Delete the associated item first
            $inventory->item->delete();
            // Then delete the inventory record
            $inventory->delete();
            
            DB::commit();
            return redirect()->route('inventory')->with('success', 'Item deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('inventory')->with('error', 'Error deleting item: ' . $e->getMessage());
        }
    }
}