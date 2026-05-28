<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::filter($request->only('name'))
            ->latest()
            ->paginate(10);

        return CategoryResource::collection($categories)
            ->additional(['message' => 'Categories retrieved successfully.']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Category::class),
            ],
            'description' => [
                'nullable',
                'string',
            ]
        ]);

        $category = Category::create($validated);

        return (new CategoryResource($category))
            ->additional(['message' => 'Category created successfully.'])
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Category $category)
    {
        return (new CategoryResource($category))
            ->additional(['message' => 'Category retrieved successfully.']);
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique(Category::class)->ignore($category),
            ],
            'description' => [
                'sometimes',
                'nullable',
                'string',
            ],
        ]);

        $category->update($validated);

        return (new CategoryResource($category->refresh()))
            ->additional(['message' => 'Category updated successfully.']);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->noContent();
    }
}
