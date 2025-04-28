<?php

namespace App\Http\Requests\PriceEndpoint;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubscribeRequest extends FormRequest
{
    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'url' => ['required', 'url'],
        ];
    }

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}
