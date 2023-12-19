<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add New Tunnel Remote') }}
            </h2>
            <Link href="{{ route('tunnels.index') }}"
                class="px-2 py-1.5 bg-indigo-500 text-indigo-100 font-semibold hover:bg-indigo-700 hover:text-white rounded-md">
            Back</Link>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-splade-form :action="route('tunnels.store')">
                        <x-splade-select name="paket_id" id="paket_id" :options="$pakets" label="Piilh Paket"   />
                        <x-splade-select name="server_id" remote-url="`/api/getserver/${form.paket_id}`" label="Piilh Server" id="server_id" />
                        <x-splade-input name="harga_paket" label="Harga" placeholder="Harga" id="harga_paket" disabled />
                        <div class="grid gap-x-6 md:grid-cols-2">
                            <div class="my-3">
                                <x-splade-input name="username" label="Username" placeholder="user tunnel remote" />
                            </div>
                            <div class="my-3">
                                <x-splade-input name="password" label="Password" placeholder="Password Tunnel" />
                            </div>
                        </div>
                        <x-splade-checkbox name="auto_renew" value="ya" false-value="tidak"
                            label="Perpanjang Otomatis!" />
                        <x-splade-submit class="mt-4" />
                    </x-splade-form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
{{-- @push('myScripts') --}}
<!-- 
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
<script>
    
$(document).ready(function() {
    $('#paket_id').on('change', function() {
        paket_id = $(this).val();

        console.log(paket_id);
        $.ajax({
            type: "GET",
            url: 'api/getharga/'+paket_id,
            cache: false,
            success: function(data) {
                $('#harga_paket').val(data);
                console.log(data);
            }
        });


    });
    });
</script>-->
{{-- @endpush  --}}