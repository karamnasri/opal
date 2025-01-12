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
            'query' => 'nullable|string',
            'is_free' => 'nullable|boolean',
            'is_liked' => 'nullable|boolean',
        ];
    }

    /**
     * This method will prepare the data for validation.
     */
    public function prepareForValidation()
    {
        if ($this->has('is_free')) {
            $this->merge([
                'is_free' => filter_var($this->input('is_free'), FILTER_VALIDATE_BOOLEAN),
            ]);
        }

        if ($this->has('is_liked')) {
            $this->merge([
                'is_liked' => filter_var($this->input('is_liked'), FILTER_VALIDATE_BOOLEAN),
            ]);
        }

        if ($this->has('print_type')) {
            $this->merge([
                'print_type' => PrintTypeEnum::from($this->input('print_type'))->value
            ]);
        }
    }
}
