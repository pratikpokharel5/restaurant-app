<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

use App\Models\Menu;
use App\Http\Resources\MenuResource;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $menus = Menu::with('category')
            ->filter($request->only(['name', 'is_available']))
            ->latest()
            ->paginate(10);

        return MenuResource::collection($menus)
            ->additional(['message' => 'Menus retrieved successfully.']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Menu::class),
            ],
            'description' => [
                'required',
                'string',
            ],
            'price' => [
                'required',
                'numeric',
                'min:0',
                'max:999999.99',
            ],
            'is_available' => [
                'required',
                'boolean',
            ],
            'image_url' => [
                'nullable',
                'string',
            ],
            'category_id' => [
                'nullable',
                'exists:categories,id',
            ],
        ]);

        $menu = Menu::create($validated);

        return (new MenuResource($menu))
            ->additional(['message' => 'Menu created successfully.'])
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Menu $menu)
    {
        return (new MenuResource($menu->load('category')))
            ->additional(['message' => 'Menu retrieved successfully.']);
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique(Menu::class)->ignore($menu),
            ],
            'description' => [
                'sometimes',
                'string',
            ],
            'price' => [
                'sometimes',
                'numeric',
                'min:0',
                'max:999999.99',
            ],
            'is_available' => [
                'sometimes',
                'boolean',
            ],
            'image_url' => [
                'sometimes',
                'nullable',
                'string',
            ],
            'category_id' => [
                'sometimes',
                'nullable',
                'exists:categories,id',
            ],
        ]);

        $menu->update($validated);

        return (new MenuResource($menu->refresh()->load('category')))
            ->additional(['message' => 'Menu updated successfully.']);
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return response()->noContent();
    }
}
