@extends('app')

@section('title', 'Create Category')

@section('content')
    <section class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
        <x-goback href="{{ route('categories.index') }}">
            Create Category
        </x-goback>

        <form class="mt-6 grid gap-5 md:grid-cols-2" method="POST" action="{{ route('categories.store') }}">
            @csrf
            <div>
                <x-label for="name">Name</x-label>

                <x-textfield id="name" name="name" placeholder="Lunch specials" value="{{ old('name') }}"
                    :error="$errors->first('name')" required />
            </div>

            <div class="md:col-span-2">
                <x-label for="description">Description</x-label>

                <x-textarea id="description" name="description" rows="4"
                    placeholder="Optional notes for staff">{{ old('description') }}</x-textarea>
            </div>

            <div class="md:col-span-2">
                <x-button type="submit">
                    <i class="fa-solid fa-check mr-2" aria-hidden="true"></i>
                    Create
                </x-button>
            </div>
        </form>
    </section>
@endsection
