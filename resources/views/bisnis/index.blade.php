<x-app-layout>
    <x-slot name="header">
       <div class="flex justify-between">
           <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               {{ __('List Tunnels') }}
           </h2>
           <Link href="{{route('bisnis.create')}}" class="px-2 py-1.5 bg-indigo-500 text-indigo-100 font-semibold hover:bg-indigo-700 hover:text-white rounded-md">New Tunnel</Link>
       </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-splade-table :for="$bisnis" striped>
                        @cell('auto_renew',$bisnis)
                        <span class="
                          {{ $bisnis->auto_renew == \App\Enums\TunnelAutoRenew::aktif ? 'text-green-500 bg-green-100 hover:text-green-700' : 'text-yellow-500 bg-yellow-100 hover:text-yellow-700' }}
                          hover:cursor-pointer font-semibold rounded-md px-4 py-0.5">
                          {{ $bisnis->auto_renew }}
                        </span>
                        @endcell
                        @cell('status',$bisnis)
                        <span class="
                          {{ $bisnis->status == App\Enums\TunnelStatus::aktif ? 'text-green-500 bg-green-100 hover:text-green-700' : 'text-yellow-500 bg-yellow-100 hover:text-yellow-700' }}
                          hover:cursor-pointer font-semibold rounded-md px-4 py-0.5">
                          {{ $bisnis->status }}
                        </span>
                        @endcell
                        @cell('actions',$bisnis)
                          <div class="flex items-center justify-center gap-x-1">
                              @if(strtotime($bisnis->expired) < strtotime(date('Y-m-d H:i:s')))
                                  <Link method="PUT" href="{{route('bisnis.renew',$bisnis)}}" class="text-blue-500 hover:text-blue-700">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-reload w-5 h-5" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                      <path d="M19.933 13.041a8 8 0 1 1 -9.925 -8.788c3.899 -1 7.935 1.007 9.425 4.747"></path>
                                      <path d="M20 4v5h-5"></path>
                                  </svg>
                                  </Link>
                              @else

                              @endif
                              <Link href="{{route('bisnis.show',$bisnis)}}" class="text-green-500 hover:text-green-700">
                              <input type="hidden" name="status" value="aktif">
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                  <path d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z"></path>
                                  <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                  <path d="M15 8l2 0"></path>
                                  <path d="M15 12l2 0"></path>
                                  <path d="M7 16l10 0"></path>
                              </svg>
                              </Link>
                              <Link href="{{route('bisnis.edit',$bisnis)}}" class="text-blue-500 hover:text-blue-700">
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit-circle" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                  <path d="M12 15l8.385 -8.415a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3z"></path>
                                  <path d="M16 5l3 3"></path>
                                  <path d="M9 7.07a7 7 0 0 0 1 13.93a7 7 0 0 0 6.929 -6"></path>
                              </svg>
                              </Link>
{{--                              <x-splade-modal name="edit-tunnel">--}}
{{--                                  <x-splade-form :default="$bisnis" method="PUT" :action="route('bisnis.update',$bisnis)">--}}
{{--                                      <x-splade-input name="password" label="Password" placeholder="*******"/>--}}
{{--                                      <x-splade-input name="to_ports_winbox" label="Port Winbox" placeholder="8291"/>--}}
{{--                                      <x-splade-input name="to_ports_api" label="Port Api" placeholder="8728"/>--}}
{{--                                      <x-splade-input name="to_ports_web" label="Port Web" placeholder="80"/>--}}
{{--                                      <x-splade-submit class="mt-4"/>--}}
{{--                                  </x-splade-form>--}}
{{--                              </x-splade-modal>--}}
                              <Link class="text-red-500 hover:text-red-700"
                                    confirm="Apakah anda yakin akan menghapus tunnel ini..."
                                    confirm-text="Anda yakin?"
                                    confirm-button="Delete!"
                                    cancel-button="No!"
                                    href="{{route('bisnis.destroy',$bisnis)}}" method="DELETE">
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash-x-filled" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                  <path d="M20 6a1 1 0 0 1 .117 1.993l-.117 .007h-.081l-.919 11a3 3 0 0 1 -2.824 2.995l-.176 .005h-8c-1.598 0 -2.904 -1.249 -2.992 -2.75l-.005 -.167l-.923 -11.083h-.08a1 1 0 0 1 -.117 -1.993l.117 -.007h16zm-9.489 5.14a1 1 0 0 0 -1.218 1.567l1.292 1.293l-1.292 1.293l-.083 .094a1 1 0 0 0 1.497 1.32l1.293 -1.292l1.293 1.292l.094 .083a1 1 0 0 0 1.32 -1.497l-1.292 -1.293l1.292 -1.293l.083 -.094a1 1 0 0 0 -1.497 -1.32l-1.293 1.292l-1.293 -1.292l-.094 -.083z" stroke-width="0" fill="currentColor"></path>
                                  <path d="M14 2a2 2 0 0 1 2 2a1 1 0 0 1 -1.993 .117l-.007 -.117h-4l-.007 .117a1 1 0 0 1 -1.993 -.117a2 2 0 0 1 1.85 -1.995l.15 -.005h4z" stroke-width="0" fill="currentColor"></path>
                              </svg>
                              </Link>
                          </div>
                       @endcell
                    </x-splade-table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
