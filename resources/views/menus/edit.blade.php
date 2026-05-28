@extends('app')

@section('title', 'Edit Menu')

@section('content')
    <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-md">
        <x-goback href="{{ route('menus.index') }}">Edit Menu</x-goback>

        <form method="POST" class="mt-3 grid grid-cols-2 gap-5" action="{{ route('menus.update', $menu) }}">
            @csrf
            @method('PUT')
            <div>
                <x-label for="name">Name</x-label>

                <x-textfield id="name" name="name" placeholder="Enter menu name..."
                    value="{{ old('name', $menu->name) }}" :error="$errors->first('name')" />
            </div>

            <div>
                <x-label for="description">Description</x-label>

                <x-textfield id="description" name="description" placeholder="Enter description..."
                    value="{{ old('description', $menu->description) }}" :error="$errors->first('description')" />
            </div>

            <div>
                <x-label for="price">Price</x-label>

                <x-textfield id="price" name="price" type="number" step="0.01" placeholder="Enter price..."
                    value="{{ old('price', $menu->price) }}" :error="$errors->first('price')" />
            </div>

            <div>
                <x-label for="is_available">Availability</x-label>

                <x-select id="is_available" name="is_available" value="{{ old('is_available', $menu->is_available) }}"
                    :error="$errors->first('is_available')">
                    <option value="1" @if (old('is_available', $menu->is_available) == '1') selected @endif>Available</option>
                    <option value="0" @if (old('is_available', $menu->is_available) == '0') selected @endif>Not Available</option>
                </x-select>
            </div>

            <div>
                <x-label for="category_id">Category</x-label>

                <x-select id="category_id" name="category_id" default-label="Select Category..."
                    value="{{ old('category_id', $menu->category_id) }}" :error="$errors->first('category_id')">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if (old('category_id', $menu->category_id) == $category->id) selected @endif>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </x-select>
            </div>

            <div class="col-span-2">
                <x-button type="submit">Update</x-button>
            </div>
        </form>
    </div>
@endsection
