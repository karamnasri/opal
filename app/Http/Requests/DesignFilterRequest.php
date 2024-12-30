<?php

namespace App\Http\Requests;

use App\Enums\PrintTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DesignFilterRequest extends FormRequest
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
            'category_id' => 'nullable|exists:categories,id',
            'print_type' => ['nullable', Rule::enum(PrintTypeEnum::class)],
            'is_free' => 'nullable|boolean',
            'is_liked' => 'nullable|boolean',
        ];
    }
}
