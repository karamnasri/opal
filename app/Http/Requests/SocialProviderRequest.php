<?php

namespace App\Http\Requests;

use App\Enums\SocialProvidersEnum;
use Illuminate\Foundation\Http\FormRequest;

class SocialProviderRequest extends FormRequest
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
            'provider' => 'required|in:' . implode(',', SocialProvidersEnum::getValues()),
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'provider' =>  $this->route('provider')
        ]);
    }

    /**
     * Custom messages for validation.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'provider.required' => 'The provider field is required.',
            'provider.in' => 'The selected provider is invalid. Please use a valid provider.',
        ];
    }
}
