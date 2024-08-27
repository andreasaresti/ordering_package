<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'date' => ['required', 'date'],
            'subtotal_amount' => ['required', 'numeric'],
            'shipping_amount' => ['required', 'numeric'],
            'discount' => ['required', 'numeric'],
            'total_amount' => ['required', 'numeric'],
        ];
    }
}
