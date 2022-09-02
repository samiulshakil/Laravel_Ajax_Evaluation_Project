<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container mt-5">
        <div class="row">
            <div class="col-xl-12 col">
                <a href="{{ route('products.index') }}" class="btn btn-primary">All Product</a>
            </div>
        </div>
    </div>
</x-app-layout>
