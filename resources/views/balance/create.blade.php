<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Request Topup Balance') }}
            </h2>
            <Link href="{{ route('dashboard') }}"
                class="px-2 py-1.5 bg-indigo-500 text-indigo-100 font-semibold hover:bg-indigo-700 hover:text-white rounded-md">
            Back</Link>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-[240px]">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-splade-form :action="route('transaction.store')">
                        <div class="grid gap-x-6 md:grid-cols-2">
                            <div class="my-3">
                                <x-splade-select name="payment_method" label="Metode Pembayaran">
                                    <option disabled selected>Pilih Metode Pembayaran</option>
                                    @foreach ($paymentChannels as $payment)
                                        <option value="{{ $payment->code }}">{{ $payment->name }} | {{ $payment->code }}
                                        </option>
                                    @endforeach
                                </x-splade-select>
                            </div>
                            <div class="my-3">
                                <x-splade-select name="amount" id="sBalance" label="Jumlah Topup Balance">
                                    <option value="10000">Rp. 10.000</option>
                                    <option value="15000">Rp. 15.000</option>
                                    <option value="20000">Rp. 20.000</option>
                                    <option value="25000">Rp. 25.000</option>
                                    <option value="50000">Rp. 50.000</option>
                                    <option value="100000">Rp. 100.000</option>
                                    <option value="200000">Rp. 200.000</option>
                                    <option value="300000">Rp. 300.000</option>
                                    <option value="500000">Rp. 500.000</option>
                                    <option value="1000000">Rp. 1.000.000</option>
                                </x-splade-select>
                                {{-- <x-splade-input name="inputAmount" label="Input Nominal"
                                    placeholder="Input Nominal Lainnya" hidden />
                                <x-splade-checkbox name="custom" id="custom"  value="ya" false-value="tidak" label="Custom Nominal" /> --}}
                            </div>
                        </div>
                        <x-splade-submit class="mt-4" />
                    </x-splade-form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
