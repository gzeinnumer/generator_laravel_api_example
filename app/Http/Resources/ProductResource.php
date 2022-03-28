<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     *   new ProductResource(object)
     *   ProductResource::collection([])
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'id_type' => $this->id_type,
            //'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            //'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
        ];
    }
}
