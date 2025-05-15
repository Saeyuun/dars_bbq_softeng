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
            return [
                'id' => $record->id,
                'item_name' => $record->inventory->item->item_name ?? 'N/A',
                'action' => $record->changes,
                'quantity' => $record->inventory->quantity ?? 0,
                'status' => $record->inventory->status ?? 'N/A',
                'employee_name' => $record->inventory->employee->employee_name ?? 'Unknown',
                'created_at' => $record->created_at
            ];
        });

        return Inertia::render('History', [
            'history' => $history
        ]);
    }
} 