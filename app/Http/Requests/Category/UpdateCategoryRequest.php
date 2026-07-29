<?php

namespace App\Http\Requests\Category;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Category::class)->ignore($this->route('category')),
            ],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ];
    }

    public function categoryData(): array
    {
        $validated = $this->validated();
        $category = $this->route('category');

        return [
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'archived_at' => $validated['status'] === 'inactive'
                ? ($category->archived_at ?? now())
                : null,
        ];
    }
}
