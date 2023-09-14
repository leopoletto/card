<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class CreateCreditCardRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'number' => ['required', 'between:13,19'],
            'expiration_year' => ['required', 'date_format:Y'],
            'expiration_month' => ['required', 'date_format:m'],
            'cvv' => ['required', 'between:3,4'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $date = Carbon::create($this->expiration_year, $this->expiration_month, 1);

                if ($date->endOfMonth()->isPast()) {
                    $validator->errors()->add(
                        'expiration',
                        'The expiration date needs to be after today'
                    );
                }

                $this->expiration = $date;
            }
        ];
    }
}
