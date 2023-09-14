<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Validator;

class CreateCardSwitcherTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'merchant_id' => ['required', 'exists:merchants,id'],
            'card_id' => ['required', 'exists:cards,id'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {

                $card = $this->user()->cards()->find($this->card_id);

                if (!$card) {
                    $validator->errors()->add(
                        'card_id',
                        'the card with the given id was not found'
                    );
                }
            }
        ];
    }
}
