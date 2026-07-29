@extends('app')

@section('title', 'Edit Category')

@section('content')
    <section class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
        <x-goback href="{{ route('categories.index') }}">
            Edit Category
        </x-goback>

        <form class="mt-6 grid gap-5 md:grid-cols-2" method="POST" action="{{ route('categories.update', $category) }}">
            @csrf
            @method('PUT')
            <div>
                <x-label for="name">Name</x-label>

                <x-textfield id="name" name="name" placeholder="Category name..."
                    value="{{ old('name', $category->name) }}" :error="$errors->first('name')" required />
            </div>

            <div>
                <x-label for="status">Category Status</x-label>

                <x-select id="status" name="status"
                    value="{{ old('status', $category->isArchived() ? 'inactive' : 'active') }}" :error="$errors->first('status')">
                    <option value="active" @if (old('status', $category->isArchived() ? 'inactive' : 'active') === 'active') selected @endif>Active</option>
                    <option value="inactive" @if (old('status', $category->isArchived() ? 'inactive' : 'active') === 'inactive') selected @endif>Inactive</option>
                </x-select>
            </div>

            <div class="md:col-span-2">
                <x-label for="description">Description</x-label>

                <x-textarea id="description" name="description" rows="4"
                    placeholder="Optional notes for staff">{{ old('description', $category->description) }}</x-textarea>
            </div>

            <div class="md:col-span-2">
                <x-button type="submit">
                    <i class="fa-solid fa-floppy-disk mr-2" aria-hidden="true"></i>
                    Update
                </x-button>
            </div>
        </form>
    </section>
@endsection
