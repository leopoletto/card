<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCreditCardRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class CreateCreditCardController extends Controller
{
    public function __invoke(CreateCreditCardRequest $request): JsonResponse
    {
        $creditCard = $request->user()
            ->creditCards()
            ->create([
                'number' => $request->validated('number'),
                'cvv' => $request->validated('cvv'),
                'expiration' => $request->expiration,
            ]);

        $number = Str::of($creditCard->number);
        $showOnly = 4;

        return response()->json([
            'id' => $creditCard->id,
            'last_digits' => $number->substr($number->length() - $showOnly, $showOnly),
            'user_id' => $creditCard->user_id
        ]);
    }
}
