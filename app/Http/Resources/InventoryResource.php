<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return ([
            'inventory_id' => $this->inventory_id,
            'item_id' => $this->item_id,
            'quantity' => $this->quanitity,
            'status' => $this->status,
        ]);
    }
}
