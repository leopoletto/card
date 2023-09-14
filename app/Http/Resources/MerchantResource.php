<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

/** @mixin \App\Models\Merchant */class MerchantResource extends JsonResource{
    public function toArray(Request $request): array
    {
        return [
'id' => $this->id,
'name' => $this->name,
'website' => $this->website,
'created_at' => $this->created_at,
'updated_at' => $this->updated_at,//
        ];
    }
}
