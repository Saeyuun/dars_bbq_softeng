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
        $items = Item::with('inventory')->get();
        return Inertia::render('Inventory', [
            'items' => $items
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'unit' => 'required|string|max:50',
            'quantity' => 'required|integer|min:0',
            'status' => 'required|in:available,out_of_stock'
        ]);

        $item = Item::create([
            'item_name' => $request->item_name,
            'description' => $request->description,
            'unit' => $request->unit
        ]);

        Inventory::create([
            'item_id' => $item->item_id,
            'employee_id' => auth()->user()->employee_id,
            'quantity' => $request->quantity,
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Item added successfully');
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'unit' => 'required|string|max:50',
            'quantity' => 'required|integer|min:0',
            'status' => 'required|in:available,out_of_stock'
        ]);

        $item->update([
            'item_name' => $request->item_name,
            'description' => $request->description,
            'unit' => $request->unit
        ]);

        $item->inventory->update([
            'quantity' => $request->quantity,
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Item updated successfully');
    }

    public function destroy(Item $item)
    {
        $item->inventory->delete();
        $item->delete();
        return redirect()->back()->with('success', 'Item deleted successfully');
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