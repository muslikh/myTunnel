<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Paket') }} - {{ $paket->name }}
            </h2>
            <Link href="{{ route('paket.index') }}"
                class="px-2 py-1.5 bg-indigo-500 text-indigo-100 font-semibold hover:bg-indigo-700 hover:text-white rounded-md">
            Back</Link>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-splade-form :default="$paket" method="PUT" :action="route('paket.update', $paket->slug)">

                        <x-splade-input name="name" label="Identity" placeholder="Paket Starter" />
                        <x-splade-input name="harga" label="Harga" placeholder="harga" />
                        <x-splade-textarea name="deskripsi" label="Deskripsi" placeholder="Deskripsi" />
                        <x-splade-submit class="mt-4" />
                    </x-splade-form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
