<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class ArchiveUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->route('user');

        return ($this->user()?->isAdmin() ?? false)
            && $user instanceof User
            && $user->id !== $this->user()->id
            && $user->role === User::ROLE_STAFF;
    }

    public function rules(): array
    {
        return [];
    }
}
