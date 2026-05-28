@extends('app')

@section('title', 'Create Category')

@section('content')
    <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-md">
        <x-goback href="{{ route('categories.index') }}">
            Categories
        </x-goback>

        <form class="mt-3 grid grid-cols-2 gap-5" method="POST" action="{{ route('categories.store') }}">
            @csrf
            <div>
                <x-label for="name">Name</x-label>

                <x-textfield id="name" name="name" placeholder="Category name..." value="{{ old('name') }}"
                    :error="$errors->first('name')" />
            </div>

            <div>
                <x-label for="description">Description</x-label>

                <x-textfield id="description" name="description" placeholder="Enter description..."
                    value="{{ old('description') }}" />
            </div>

            <div class="col-span-2">
                <x-button type="submit">Create</x-button>
            </div>
        </form>
    </div>
@endsection
