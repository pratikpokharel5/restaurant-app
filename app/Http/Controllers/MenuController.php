<?php

namespace App\Http\Controllers;

use App\Http\Requests\Menu\StoreMenuRequest;
use App\Http\Requests\Menu\UpdateMenuRequest;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Menu::class);

        $menus = Menu::with('category')
            ->filter($request->only(['search', 'is_available']))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('menus.index', compact('menus'));
    }

    public function create()
    {
        $this->authorize('create', Menu::class);

        $categories = Category::active()->orderBy('name')->get();

        return view('menus.create', compact('categories'));
    }

    public function store(StoreMenuRequest $request)
    {
        Menu::create($request->validated());

        return redirect()
            ->route('menus.index')
            ->with('message', 'Menu created successfully.');
    }

    public function edit(Menu $menu)
    {
        $this->authorize('update', $menu);

        $categories = Category::active()->orderBy('name')->get();

        return view('menus.edit', compact('menu', 'categories'));
    }

    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        $menu->update($request->validated());

        return redirect()
            ->route('menus.index')
            ->with('message', 'Menu updated successfully.');
    }
}
