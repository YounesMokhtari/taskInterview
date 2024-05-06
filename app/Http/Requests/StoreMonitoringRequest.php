<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMonitoringRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:35|unique:monitors,name',
            'url' => 'required|string|url',
            'interval' => 'required|numeric|min:1|max:60',
            'method' => 'sometimes|string|in:put,get,post,patch,delete',
            'body' => 'sometimes',
            'body.*.key' => 'required|string',
            'body.*.value' => 'required'
        ];
    }
}
