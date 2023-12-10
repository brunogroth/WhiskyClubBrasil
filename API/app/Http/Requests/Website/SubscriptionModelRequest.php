<?php

namespace App\Http\Requests\Website;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubscriptionModelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('subscription_models')->ignore($this->id)
            ],
            'description' => [
                'required',
                'string'
            ],
            'image_url' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|' . Rule::requiredIf(!$this->id),
            'price' => [
                'required',
                'decimal:2',
                'between:0,9999999.99'
            ],
            'discount_price' => [
                'decimal:2',
                'between:0,9999999.99'
            ],
            'checkout_url' => [
                'required',
                'url'
            ]
        ];
    }
}
