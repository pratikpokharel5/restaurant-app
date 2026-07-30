<?php

namespace App\Http\Requests\Menu;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Menu::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique(Menu::class)],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'is_available' => ['required', 'boolean'],
            'category_id' => [
                'required',
                Rule::exists(Category::class, 'id')->whereNull('archived_at'),
            ],
        ];
    }
}
