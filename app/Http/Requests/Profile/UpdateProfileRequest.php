<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'name' => [$this->user()->isAdmin() ? 'nullable' : 'required', 'string', 'max:255'],
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ];
    }

    public function profileData(): array
    {
        $validated = $this->validated();

        return array_filter([
            'name' => $this->user()->isAdmin()
                ? $this->user()->name
                : $validated['name'],
            'password' => $validated['password'] ?? null,
        ], fn ($value) => filled($value));
    }
}
