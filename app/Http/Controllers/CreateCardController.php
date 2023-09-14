<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCardRequest;
use Illuminate\Http\JsonResponse;

class CreateCardController extends Controller
{
    public function __invoke(CreateCardRequest $request): JsonResponse
    {
        $card = $request->user()
            ->cards()
            ->create([
                'number' => $request->validated('number'),
                'cvv' => $request->validated('cvv'),
                'expiration' => $request->expiration,
            ]);

        return response()->json([
            'id' => $card->id,
            'last_digits' => $request->last_digits,
            'user_id' => $card->user_id
        ]);
    }
}
