<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge(parent::toArray($request), [
            'customer' => [
                'id' => $this->customer->id,
                'name' => $this->customer->name,
            ],
            'items' => $this->items->map(function ($item) {
                return array_merge($item->toArray(), [
                    'menu' => [
                        'id' => $item->menu->id,
                        'name' => $item->menu->name,
                    ],
                ]);
            }),
        ]);
    }
}
