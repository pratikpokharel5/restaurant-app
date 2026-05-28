<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Menu;
use App\Models\Category;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $menus = Menu::with('category')
            ->filter($request->only(['search', 'is_available']))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('menus.index', compact('menus'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('menus.create', compact('categories'));
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
            'category_id' => [
                'required',
                'exists:categories,id',
            ]
        ]);

        Menu::create($validated);

        return redirect()
            ->route('menus.index')
            ->with('message', 'Menu created successfully.');
    }

    public function edit(Menu $menu)
    {
        $categories = Category::all();

        return view('menus.edit', compact('menu', 'categories'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Menu::class)->ignore($menu),
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
            'category_id' => [
                'required',
                Rule::exists(Category::class, 'id'),
            ],
        ]);

        $menu->update($validated);

        return redirect()
            ->route('menus.index')
            ->with('message', 'Menu updated successfully.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()
            ->route('menus.index')
            ->with('message', 'Menu deleted successfully.');
    }
}
