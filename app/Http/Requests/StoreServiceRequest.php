<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class StoreServiceRequest extends ApiFormRequest
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
            //
            'title' => 'required|string|max:225',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|max:10000',
            'price' => 'required|numeric|min:10000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
