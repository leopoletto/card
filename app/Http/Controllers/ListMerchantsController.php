<?php

namespace App\Http\Controllers;

use App\Http\Resources\MerchantResource;
use App\Models\Merchant;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ListMerchantsController extends Controller
{
    public function __invoke(): ResourceCollection
    {
        return MerchantResource::collection(
            Merchant::cursorPaginate(10)
        );
    }
}
