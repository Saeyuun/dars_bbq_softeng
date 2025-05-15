<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\InventoryResource;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\InventoryHistory;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class InventoryController extends Controller
{
    public function index()
    {
        $items = Item::with(['inventory' => function($query) {
            $query->latest();
        }])->get();
        
        return Inertia::render('Inventory', [
            'items' => $items
        ]);
    }

    public function store(Request $request)
    {
        try {
        $request->validate([
                'item_name' => 'required|string|max:255',
            'description' => 'nullable|string',
                'unit' => 'required|string|max:50',
                'inventory' => 'required|array',
                'inventory.quantity' => 'required|integer|min:0',
                'inventory.status' => 'required|in:available,out_of_stock'
        ]);

            DB::beginTransaction();

            // Create the item first
            $item = Item::create([
                'item_name' => $request->item_name,
                'description' => $request->description,
                'unit' => $request->unit
            ]);

            Log::info('Item created successfully', ['item_id' => $item->item_id]);

            // Create the inventory record
            $inventory = Inventory::create([
                'item_id' => $item->item_id,
                'employee_id' => auth()->user()->employee_id,
                'quantity' => $request->inventory['quantity'],
                'status' => $request->inventory['status']
            ]);

            Log::info('Inventory record created successfully', ['inventory_id' => $inventory->inventory_id]);

            // Log the creation in inventory history
            $history = InventoryHistory::create([
                'inventory_id' => $inventory->inventory_id,
                'item_name' => $item->item_name,
                'changes' => 'added',
                'quantity_at_time' => $request->inventory['quantity'],
                'status_at_time' => $request->inventory['status']
            ]);

            Log::info('History record created successfully', ['history_id' => $history->id]);

            DB::commit();
            return redirect()->back()->with('success', 'Item added successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to add item: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all()
            ]);
            return redirect()->back()->with('error', 'Failed to add item: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'item_name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'unit' => 'sometimes|required|string|max:50',
            'inventory' => 'required|array',
            'inventory.quantity' => 'required|integer|min:0',
            'inventory.status' => 'required|in:available,out_of_stock'
        ]);

        DB::beginTransaction();
        try {
            if ($request->has('item_name')) {
                $item->update([
                    'item_name' => $request->item_name,
                    'description' => $request->description,
                    'unit' => $request->unit
                ]);
            }

            // Get fresh inventory data to ensure we have the current values
            $currentInventory = Inventory::where('item_id', $item->item_id)->first();

            if ($currentInventory) {
                // Determine status based on quantity
                $newStatus = $request->inventory['quantity'] === 0 ? 'out_of_stock' : 'available';

                // Update the inventory first
                $currentInventory->update([
                    'quantity' => $request->inventory['quantity'],
                    'status' => $newStatus
                ]);

                // Log the update in inventory history with the new values
                InventoryHistory::create([
                    'inventory_id' => $currentInventory->inventory_id,
                    'item_name' => $item->item_name,
                    'changes' => 'updated',
                    'quantity_at_time' => $request->inventory['quantity'],
                    'status_at_time' => $newStatus
                ]);
            } else {
                // Determine status based on quantity for new items
                $newStatus = $request->inventory['quantity'] === 0 ? 'out_of_stock' : 'available';

                $inventory = Inventory::create([
                    'item_id' => $item->item_id,
                    'employee_id' => auth()->user()->employee_id,
                    'quantity' => $request->inventory['quantity'],
                    'status' => $newStatus
                ]);

                // Log the creation in inventory history
                InventoryHistory::create([
                    'inventory_id' => $inventory->inventory_id,
                    'item_name' => $item->item_name,
                    'changes' => 'added',
                    'quantity_at_time' => $request->inventory['quantity'],
                    'status_at_time' => $newStatus
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Item updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update item: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update item');
        }
    }

    public function destroy(Item $item)
    {
            DB::beginTransaction();
        try {
            if ($item->inventory) {
                // Log the deletion in inventory history
                InventoryHistory::create([
                    'inventory_id' => $item->inventory->inventory_id,
                    'item_name' => $item->item_name,
                    'changes' => 'deleted',
                    'quantity_at_time' => $item->inventory->quantity,
                    'status_at_time' => $item->inventory->status
                ]);

                $item->inventory->delete();
            }
            $item->delete();
            
            DB::commit();
            return redirect()->back()->with('success', 'Item deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete item: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete item');
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $items = Item::with('inventory')
            ->where('item_name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->get();
        
        return response()->json($items);
    }
}