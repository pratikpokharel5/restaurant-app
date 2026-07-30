<?php

namespace App\Http\Requests\Menu;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        $menu = $this->route('menu');

        return $menu instanceof Menu
            && ($this->user()?->can('update', $menu) ?? false);
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Menu::class)->ignore($this->route('menu')),
            ],
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
