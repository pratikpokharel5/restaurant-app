<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ];
    }

    public function credentials(): array
    {
        return $this->only(['email', 'password']) + ['archived_at' => null];
    }

    public function hasArchivedUserWithValidPassword(): bool
    {
        $user = User::where('email', $this->string('email'))->first();

        return $user?->isArchived() === true
            && Hash::check($this->string('password'), $user->password);
    }
}
