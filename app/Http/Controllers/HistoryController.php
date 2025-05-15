<?php

namespace App\Http\Controllers;

use App\Models\InventoryHistory;
use App\Models\Item;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = InventoryHistory::with(['inventory.item', 'inventory.employee'])
            ->orderBy('created_at', 'desc');

        $history = $query->get()->map(function ($record) {
            // If the inventory record is null (deleted), use the stored values
            if (!$record->inventory) {
                return [
                    'id' => $record->id,
                    'item_name' => $record->item_name,
                    'action' => $record->changes,
                    'quantity' => $record->quantity_at_time ?? 'N/A',
                    'status' => $record->status_at_time ?? 'N/A',
                    'employee_name' => 'Unknown',
                    'created_at' => $record->created_at
                ];
            }

            return [
                'id' => $record->id,
                'item_name' => $record->item_name,
                'action' => $record->changes,
                'quantity' => $record->quantity_at_time ?? $record->inventory->quantity ?? 0,
                'status' => $record->status_at_time ?? $record->inventory->status ?? 'N/A',
                'employee_name' => $record->inventory->employee->employee_name ?? 'Unknown',
                'created_at' => $record->created_at
            ];
        });

        return Inertia::render('History', [
            'history' => $history
        ]);
    }
} 