<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryHistory;
use Inertia\Inertia;

class InventoryHistoryController extends Controller
{
    public function index()
    {
        $history = InventoryHistory::with('item')->orderBy('created_at', 'desc')->get();
        return Inertia::render('History', [
            'items' => $history->map(function ($h) {
                return [
                    'id' => $h->id,
                    'name' => $h->item ? $h->item->item_name : 'Unknown',
                    'status' => ucfirst($h->status),
                    'newQuantity' => $h->item ? $h->item->quantity : null,
                    'dateAdded' => $h->created_at->format('Y-m-d'),
                ];
            }),
        ]);
    }
}
