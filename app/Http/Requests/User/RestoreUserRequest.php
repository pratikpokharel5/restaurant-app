<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class RestoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->route('user');

        return ($this->user()?->isAdmin() ?? false)
            && $user instanceof User
            && $user->role === User::ROLE_STAFF;
    }

    public function rules(): array
    {
        return [];
    }
}
