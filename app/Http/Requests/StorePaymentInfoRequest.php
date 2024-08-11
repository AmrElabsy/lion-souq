<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return isVendor();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => 'required|string',
            "payment_gateway" => 'required|string',
            "public_key" => 'required|string',
            "secret_key" => 'required|string',
            "additional_info" => 'nullable|string',
            "vendor_id" => "required|exists:vendors,id",
        ];
    }
}
