<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Details Tunnel') }} - {{$bisnis->username}}
            </h2>
            <Link href="{{route('tunnels.index')}}" class="px-2 py-1.5 bg-indigo-500 text-indigo-100 font-semibold hover:bg-indigo-700 hover:text-white rounded-md">Back</Link>
        </div>
    </x-slot>
    <div class="py-12">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                

                <div class="p-6 bg-gray-200 border-b border-gray-200">
                    
                    <div class="lg:col-span-9">
                        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            <div class="bg-white border text-slate-800 group relative block !border-none rounded-xl p-3 shadow lg:p-6">
                                <div class="mb-2 flex items-center justify-between">
                                    <h4 class="font-mono text-base tracking-tighter sm:text-3xl">
                                       @if($bisnis->status == \App\Enums\TunnelAutoRenew::aktif)
                                            <div role="status">
                                                <svg aria-hidden="true" class="w-6 h-6 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-green-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                                </svg>
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        @else
                                            <div role="status">
                                                <svg aria-hidden="true" class="w-6 h-6 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-red-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                                </svg>
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        @endif
                                    </h4>
                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-100 text-slate-900 fade group-hover:bg-red-100 group-hover:text-red-900 lg:h-10 lg:w-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 lg:h-5 lg:w-5">
                                            <path d="M19 4v16h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12z"></path>
                                            <path d="M19 16h-12a2 2 0 0 0 -2 2"></path>
                                            <path d="M9 8h6"></path>
                                        </svg>
                                    </div>
                                </div>
                                <span class="grid grid-cols-4">
                                <span class="text-xs tracking-tight text-muted sm:text-sm">
                                    {{$bisnis->status == \App\Enums\TunnelStatus::aktif ? 'aktif':'nonaktif'}}
                                    @if($bisnis->status == \App\Enums\TunnelStatus::aktif)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-autofit-content-filled text-green-600" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                           <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                           <path d="M6.707 3.293a1 1 0 0 1 .083 1.32l-.083 .094l-1.292 1.293h4.585a1 1 0 0 1 .117 1.993l-.117 .007h-4.585l1.292 1.293a1 1 0 0 1 .083 1.32l-.083 .094a1 1 0 0 1 -1.32 .083l-.094 -.083l-3 -3a1.008 1.008 0 0 1 -.097 -.112l-.071 -.11l-.054 -.114l-.035 -.105l-.025 -.118l-.007 -.058l-.004 -.09l.003 -.075l.017 -.126l.03 -.111l.044 -.111l.052 -.098l.064 -.092l.083 -.094l3 -3a1 1 0 0 1 1.414 0z" stroke-width="0" fill="currentColor"></path>
                                           <path d="M18.613 3.21l.094 .083l3 3a.927 .927 0 0 1 .097 .112l.071 .11l.054 .114l.035 .105l.03 .148l.006 .118l-.003 .075l-.017 .126l-.03 .111l-.044 .111l-.052 .098l-.074 .104l-.073 .082l-3 3a1 1 0 0 1 -1.497 -1.32l.083 -.094l1.292 -1.293h-4.585a1 1 0 0 1 -.117 -1.993l.117 -.007h4.585l-1.292 -1.293a1 1 0 0 1 -.083 -1.32l.083 -.094a1 1 0 0 1 1.32 -.083z" stroke-width="0" fill="currentColor"></path>
                                           <path d="M18 13h-12a3 3 0 0 0 -3 3v2a3 3 0 0 0 3 3h12a3 3 0 0 0 3 -3v-2a3 3 0 0 0 -3 -3z" stroke-width="0" fill="currentColor"></path>
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-wifi-off text-red-600" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                           <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                           <path d="M12 18l.01 0"></path>
                                           <path d="M9.172 15.172a4 4 0 0 1 5.656 0"></path>
                                           <path d="M6.343 12.343a7.963 7.963 0 0 1 3.864 -2.14m4.163 .155a7.965 7.965 0 0 1 3.287 2"></path>
                                           <path d="M3.515 9.515a12 12 0 0 1 3.544 -2.455m3.101 -.92a12 12 0 0 1 10.325 3.374"></path>
                                           <path d="M3 3l18 18"></path>
                                        </svg>
                                    @endif
                                </span>
                                <span class="text-xs tracking-tight text-muted sm:text-sm">
                                   koneksi:
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-link-off text-red-600" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                       <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                       <path d="M9 15l3 -3m2 -2l1 -1"></path>
                                       <path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464"></path>
                                       <path d="M3 3l18 18"></path>
                                       <path d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463"></path>
                                    </svg>
                                </span>
                                </span>
                                
                            </div>


                            
                        </div>
                    </div>


                    <span class="hover:cursor-pointer bg-white border text-slate-800 mt-4 group relative block !border-none rounded-xl p-3 shadow lg:p-6">
                                <div class="mb-2 flex items-center justify-between">
                                    <h4 class="font-mono text-base tracking-tighter sm:text-3xl">Silahkan Copy L2TP Script</h4>
                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-100 text-slate-900 fade group-hover:bg-red-100 group-hover:text-red-900 lg:h-10 lg:w-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 lg:h-5 lg:w-5">
                                            <path d="M19 4v16h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12z"></path>
                                            <path d="M19 16h-12a2 2 0 0 0 -2 2"></path>
                                            <path d="M9 8h6"></path>
                                        </svg>
                                    </div>
                                </div>
                                <span class="text-xs tracking-tight text-muted sm:text-sm">
                                   <code id="code-to-copy">:if ([:len [/ppp profile find name="{{$bisnis->domain}}"]]=0) do={/ppp profile add name="{{$bisnis->domain}}" comment="{{$bisnis->domain}}"};/interface l2tp-client add user="{{$bisnis->username}}" password="{{$bisnis->password}}" connect-to="{{$bisnis->domain}}" profile={{$bisnis->domain}} name="l2tp-{{$bisnis->domain}}-{{$bisnis->username}}" keepalive-timeout=10 use-peer-dns=no disabled=no comment="{{$bisnis->domain}}-{{$bisnis->username}} L2TP";</code>
                                </span>
                            </span>

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Tanggal Daftar
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Expired
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Username
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Password
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Domain
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Host / IP
                                </th>
                                
                                <th scope="col" class="px-6 py-3">
                                    Local Gateway
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Local IP
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-pink-600">
                                    {{$bisnis->created_at}}
                                </th>
                                <td class="px-6 py-4 text-red-600">
                                    {{$bisnis->expired}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$bisnis->username}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$bisnis->password}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$bisnis->domain}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$bisnis->ip_server}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$bisnis->local_addrss}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$bisnis->ip_tunnel}}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-2">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                
                <div class="p-6 bg-gray-200 border-b border-gray-200">
                    

                    {{-- <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4"> --}}
                            
                        <div class="flex justify-between py-4">
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                {{ __('Data Port Forwarding') }}
                            </h2>
                            <Link  href="#tambah-port" class="px-2 py-1.5 bg-indigo-500 text-indigo-100 font-semibold hover:bg-indigo-700 hover:text-white rounded-md">Tambah Port</Link>
                        
                        </div>

                        <x-splade-table :for="$ports" striped>
                            <x-slot>
                                <div class="flex text-center justify-center text-red-500">There are no items to show</div>
                            </x-slot>
                            @cell('label',$ports)
                            <span class="">
                                 {{ $ports->label }}
                            </span>
                            @endcell
                            @cell('local_port',$ports)
                            <span class="">
                                {{ $ports->bisnis[0]->ip_tunnel }} : {{ $ports->port }}
                            </span>
                            @endcell
                            @cell('public_port',$ports)
                            <span class="">
                                
                                {{ $ports->bisnis[0]->ip_server }} : {{ $ports->to_port }}
                            </span>
                            @endcell
                            @cell('status',$ports)
                            <span class="">
                                
                                {{ $ports->status }}
                            </span>
                            @endcell
                            @cell('actions',$ports)
                            <div class="flex gap-x-1">
                                
                                <Link href="" class="text-blue-500 hover:text-blue-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit-circle" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 15l8.385 -8.415a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3z"></path>
                                        <path d="M16 5l3 3"></path>
                                        <path d="M9 7.07a7 7 0 0 0 1 13.93a7 7 0 0 0 6.929 -6"></path>
                                    </svg>
                                    </Link>
                                
                             <Link  href="#generate" class="px-2 py-1.5 bg-indigo-500 text-indigo-100 font-semibold hover:bg-indigo-700 hover:text-white rounded-md">
                                generate
                            </Link>
                            
                              <Link class="text-red-500 hover:text-red-700"
                                confirm="Apakah anda yakin akan menghapus tunnel ini..."
                                confirm-text="Anda yakin?"
                                confirm-button="Delete!"
                                cancel-button="No!"
                                href="{{ route('bisnis.dellPort',$ports->id) }}" method="DELETE">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash-x-filled" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M20 6a1 1 0 0 1 .117 1.993l-.117 .007h-.081l-.919 11a3 3 0 0 1 -2.824 2.995l-.176 .005h-8c-1.598 0 -2.904 -1.249 -2.992 -2.75l-.005 -.167l-.923 -11.083h-.08a1 1 0 0 1 -.117 -1.993l.117 -.007h16zm-9.489 5.14a1 1 0 0 0 -1.218 1.567l1.292 1.293l-1.292 1.293l-.083 .094a1 1 0 0 0 1.497 1.32l1.293 -1.292l1.293 1.292l.094 .083a1 1 0 0 0 1.32 -1.497l-1.292 -1.293l1.292 -1.293l.083 -.094a1 1 0 0 0 -1.497 -1.32l-1.293 1.292l-1.293 -1.292l-.094 -.083z" stroke-width="0" fill="currentColor"></path>
                                    <path d="M14 2a2 2 0 0 1 2 2a1 1 0 0 1 -1.993 .117l-.007 -.117h-4l-.007 .117a1 1 0 0 1 -1.993 -.117a2 2 0 0 1 1.85 -1.995l.15 -.005h4z" stroke-width="0" fill="currentColor"></path>
                                </svg>
                              </Link>
                            </div>
                        @endcell
                        
                        </x-splade-table>
                    {{-- </div> --}}

                </div>
            </div>
        </div>
    </div>

 <x-splade-modal name="tambah-port">
    <x-splade-form method="POST" >
        <x-splade-input type="text" name="label" label="Label Port" placeholder=""/>
        <x-splade-input type="number" name="port" label="Port Local" placeholder=""/>
            @if($paket == 'Bussiness Enterprise')
            <x-splade-input type="number" name="to_port" label="Port Public" placeholder=""  />
            @else
            {{-- <x-splade-input type="number" name="to_port" label="Port Public" placeholder=""  /> --}}
            @endif
        <x-splade-submit class="mt-4"/>
    </x-splade-form>
</x-splade-modal>


<x-splade-modal name="generate">
    <x-splade-form method="POST" >
        info: script ini berfungsi untuk mengonlinekan perangkat di bawah mikrtik seperti ap ccttv webserver dll
        <x-splade-input type="text" name="label" label="Public Access" readonly/>
        <x-splade-input type="number" name="port" label="Local IP VPN" readonly/>
        <x-splade-input type="number" name="port" label="IP Perangkat(Perangkat Di bawah mikrotik)" readonly/>
        <x-splade-input type="number" name="port" label="Port Perangkat" readonly/>
        <br>
        #Copy Paste Pada New Terminal Mikrotik
/ip firewall nat remove[find comment="tunnel-nat-10.10.10.126-1212"] 
/ip firewall nat add action=dst-nat chain=dstnat protocol=tcp dst-address="10.10.10.126" dst-port="1212" to-address="192.168.10.100" to-ports="80" comment="tunnel"
        <x-splade-textarea name="biography" autosize/>
        <x-splade-submit class="mt-4"/>
    </x-splade-form>
</x-splade-modal>

</x-app-layout>
