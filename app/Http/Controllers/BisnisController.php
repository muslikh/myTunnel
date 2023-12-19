<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Server;
use App\Models\Port;
use App\Models\Transaction;
use App\Models\Bisnis;
use App\Models\User;
use App\Models\UserBalace;
use App\Repositories\RouterOsRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use ProtoneMedia\Splade\Facades\Toast;
use ProtoneMedia\Splade\SpladeTable;
use RouterOS\Exceptions\BadCredentialsException;
use RouterOS\Exceptions\ClientException;
use RouterOS\Exceptions\ConfigException;
use RouterOS\Exceptions\ConnectException;
use RouterOS\Exceptions\QueryException;

class BisnisController extends Controller
{
    private RouterOsRepository $routerOsRepository;

    public function __construct(RouterOsRepository $routerOsRepository)
    {
        $this->routerOsRepository = $routerOsRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bisnis = Bisnis::where('user_id', auth()->user()->id)->paginate(5);

        return view('bisnis.index', [
            'bisnis' => SpladeTable::for($bisnis)
                ->column(
                    'username',
                    sortable: true
                )->withGlobalSearch(columns: ['username', 'server'])
                ->column('username')
                ->column('domain')
                ->column('server')
                ->column('auto_renew')
                ->column('status')
                ->column('expired')
                ->column('actions')
            //                ->paginate(5)
            ,

        ]);
    }

    public function async()
    {
        return view('bisnis.async', [
            'bisnis' => SpladeTable::for(Bisnis::class)
                ->column(
                    'username',
                    sortable: true
                )->withGlobalSearch(columns: ['username', 'server'])
                ->column('username')
                ->column('domain')
                ->column('server')
                ->column('auto_renew')
                ->column('status')
                ->column('expired')
                ->column('actions')
                ->paginate(5),

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $servers = Server::pluck('name', 'id')->toArray();
        $pakets = Paket::where('name', 'like', "%Business%")
        ->pluck('name', 'id')->toArray();
// dd($servers);
        return view('bisnis.create', [
            'servers' => $servers,
            'pakets' => $pakets,
        ]);
    }

    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws BadCredentialsException
     * @throws QueryException
     * @throws ConfigException
     */
    public function store(Request $request)
    {
        
        $server = Server::where('id', $request->server_id)->first();
        $harga_paket = Paket::where('id', $request->paket_id)->first();
        // $previousPorts = Bisnis::pluck('api')->merge(Bisnis::pluck('web'))->merge(Bisnis::pluck('winbox'))->toArray();
        // $portapi = generatePort(4, $previousPorts);
        // $portwinbox = generatePort(4, $previousPorts);
        // $portweb = generatePort(4, $previousPorts);
        
        // dd($harga_paket->harga);
        
        $autoRenew = $request->auto_renew;
        $existing_ips = Bisnis::pluck('ip_tunnel');
        $iptunnel = '10.10.21.' . rand(40, 253);
        while ($existing_ips->contains($iptunnel)) {
            $iptunnel = '10.10.21.' . rand(40, 253);
        }
        $localaddress = '10.10.21.1';

        $debit = auth()->user()->balances()->where('balance', '>=', 0)->get('balance')->sum('balance');
        $credit = auth()->user()->balances()->where('balance', '<', 0)->get('balance')->sum('balance');
        $balance = $debit + $credit;

        
        if (empty($request->username)) {
            throw ValidationException::withMessages([
                'server_id' => 'Pilih server terlebih dahulu',
                'username' => 'Username tidak boleh kosong Silahkan isi username',
                'password' => 'Password tidak boleh kosong',
            ]);
        }
        

        if ($balance <= 0) {
            Toast::title('Gagal membuat tunnel!.')
                ->message('Balance anda tidak mencukupi.')
                ->warning()
                ->backdrop()
                ->autoDismiss(5);

            return to_route('tunnels.create');
        }

        
        
        $request->validate([
            'server_id' => ['required'],
            'username' => ['required', Rule::unique('bisnis', 'username')],
            'password' => ['required', 'min:6'],
        ]);
        $mainprofile = 'default';

        try {
           DB::beginTransaction();
        //    dd($request->server_id);
           auth()->user()->bisnis()->create([
                'username' => $name = $request->username,
                'password' => $pass = $request->password,
                'ip_server' => $server->host,
                'server_id' => $request->server_id,
                'server' => $server->name,
                'local_addrss' => $localaddress,
                'ip_tunnel' => $remoteadress = $iptunnel,
                'domain' => $server->domain,
                'expired' => now()->addMonth(),
            ]);

            
            // dd($harga_paket->harga);
            auth()->user()->transactions()->create([
                'amount' => $harga_paket->harga,
                'reference' => 'TUN' . time(),
                'merchant_ref' => 'TINV-' . time(),
                'type' => 'Order Layanan Tunnel',
                'status' => 'PAID',
            ]);

            auth()->user()->balances()->create([
                'balance' => -$harga_paket->harga,
            ]);
            $this->routerOsRepository->addTunnel($server, $name, $pass, $localaddress, $remoteadress, $mainprofile);
            // $this->routerOsRepository->addFirewallNatApi($server, $name, $remoteadress, $portapi);
            // $this->routerOsRepository->addFirewallNatWinbox($server, $name, $remoteadress, $portwinbox);
            // $this->routerOsRepository->addFirewallNatWeb($server, $name, $remoteadress, $portweb);

            DB::commit();
            Toast::title('Tunnel  berhasil di buat.')
                ->message('Anda berhasil membuat tunnel .')
                ->backdrop()
                ->autoDismiss(3);

            return to_route('bisnis.index');
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Bisnis $bisni)
    {
        // dd($bisnis);
        $ports = Port::with('bisnis')->where('bisnis_id',$bisni->id)->paginate(5);
        $paket = Server::with('paket')->where('id',$bisni->server_id)->first();
        
        // dd($disabled);
        return view('bisnis.show', [
            'bisnis' => $bisni,
            'ports' => SpladeTable::for($ports)
            ->withGlobalSearch()
            ->column('label')
            ->column('local_port')
            ->column('public_port')
            ->column('status')
            ->column('actions'),
            // ->paginate(5),
            'paket' => $paket->paket->name
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bisnis $bisni)
    {
        // dd($bisni);
        return view('bisnis.edit', [
            'bisnis' => $bisni,
        ]);
    }

    public function sync(Bisnis $bisni)
    {
        $servers = Server::get();
        $users = User::get();

        return view('bisnis.sync', [
            'bisnis' => $bisni,
            'servers' => $servers,
            'users' => $users,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bisnis $bisni)
    {
        $sid = $bisni->server_id;
        $server = Server::where('id', $sid)->first();
        $request->validate([
            'password' => ['required'],
        ]);
        $auto_renew = $request->auto_renew;
        $password = $request->password;
        // $to_ports_web = $request->to_ports_web;
        // $to_ports_api = $request->to_ports_api;
        // $to_ports_winbox = $request->to_ports_winbox;
        //        $bisnis = Bisnis::where('username', $bisnis->username)->first();
        $bisni->update([
            'auto_renew' => $auto_renew,
            'password' => $password,
            // 'to_ports_web' => $to_ports_web,
            // 'to_ports_api' => $to_ports_api,
            // 'to_ports_winbox' => $to_ports_winbox,
        ]);

        $username = $bisni->username;

        // // ==============api================
        // $rapi = $request->api;
        // $pap = $bisni->api;
        // $this->routerOsRepository->updatePortApi($rapi, $pap, $server);
        // // ==============api================

        // // ==============winbox================
        // $pwin = $request->winbox;
        // $win = $bisni->winbox;
        // $this->routerOsRepository->updatePortWinbox($pwin, $win, $server);
        // // ==============winbox================

        // // ==============web================
        // $pweb = $request->web;
        // $web = $bisni->web;
        // $this->routerOsRepository->updatePortWeb($pweb, $web, $server);
        // // ==============web================
        // $this->routerOsRepository->updatePassPpp($username, $password, $server);

        Toast::title('Updated bisnis.')
            ->message('Anda berhasil mengupdate tunnel remote.')
            ->backdrop()
            ->autoDismiss(2);

        return to_route('bisnis.show', $bisni);
    }

    /**
     * @throws ConnectException
     * @throws QueryException
     * @throws ClientException
     * @throws BadCredentialsException
     * @throws ConfigException
     */
    public function reasync(Request $request, Tunnel $bisni)
    {
        $sid = $request->server_id;
        $server = Server::where('id', $sid)->first();
        $request->validate([
            'password' => ['required'],
        ]);
        $autoRenew = $request->auto_renew;
        $status = $request->status;
        $uid = $request->user_id;
        $password = $request->password;
        $to_ports_web = $request->to_ports_web;
        $to_ports_api = $request->to_ports_api;
        $to_ports_winbox = $request->to_ports_winbox;
        $expired = $request->expired;
        $bisni->update([
            'status' => $status,
            'server_id' => $sid,
            'user_id' => $uid,
            'password' => $password,
            'to_ports_web' => $to_ports_web,
            'to_ports_api' => $to_ports_api,
            'to_ports_winbox' => $to_ports_winbox,
            'username' => $bisnis->username,
            'ip_server' => $server->host,
            'server' => $server->name,
            'auto_renew' => $autoRenew,
            'local_addrss' => $bisni->local_addrss,
            'ip_tunnel' => $bisni->ip_tunnel,
            'domain' => $server->domain,
            'api' => $bisni->api,
            'winbox' => $bisni->winbox,
            'expired' => $expired,
            'web' => $bisni->web,
        ]);

        $username = $bisni->username;

        // ==============api================
        $rapi = $request->api;
        $pap = $bisni->api;
        $this->routerOsRepository->updatePortApi($rapi, $pap, $server);
        // ==============api================

        // ==============winbox================
        $pwin = $request->winbox;
        $win = $bisni->winbox;
        $this->routerOsRepository->updatePortWinbox($pwin, $win, $server);
        // ==============winbox================

        // ==============web================
        $pweb = $request->web;
        $web = $bisni->web;
        $this->routerOsRepository->updatePortWeb($pweb, $web, $server);
        // ==============web================
        $this->routerOsRepository->updatePassPpp($username, $password, $server);

        Toast::title('Success reasync bisnis.')
            ->message('Anda berhasil mengupdate tunnel remote.')
            ->backdrop()
            ->autoDismiss(2);

        return to_route('bisnis.show', $bisni);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bisnis $bisni)
    {
        $sid = $bisni->server_id;
        $server = Bisnis::where('id', $sid)->first();
        $username = $bisni->username;
        $pap = $bisni->api;
        $win = $bisni->winbox;
        $web = $bisni->web;
        $this->routerOsRepository->disablePpp($server, $username);
        $this->routerOsRepository->deletePortApi($server, $pap);
        $this->routerOsRepository->deletePortWeb($server, $web);
        $this->routerOsRepository->deletePortWinbox($server, $win);
        $this->routerOsRepository->deletePppSecret($username, $server);
        $this->routerOsRepository->deleteActiveSecret($server, $username);
        $bisni->delete();
        Toast::title('Success deleted.')
            ->message('Tunnel berhasil di hapus.')
            ->backdrop()
            ->autoDismiss(2);

        return to_route('bisnis.index');
    }

    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws QueryException
     * @throws BadCredentialsException
     * @throws ConfigException
     */
    public function removeActive(Bisnis $bisni)
    {
        $sid = $bisni->server_id;
        $server = Server::where('id', $sid)->first();
        $username = $bisni->username;
        $this->routerOsRepository->deleteActiveSecret($server, $username);

        $bisnis->update([
            'status' => 'nonaktif',
        ]);
        Toast::title('Success disabled.')
            ->message('Tunnel berhasil di nonaktifkan.')
            ->backdrop()
            ->autoDismiss(2);

        return back();
    }


    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws BadCredentialsException
     * @throws QueryException
     * @throws ConfigException
     */
    public function renew(Bisnis $bisni)
    {
        try {
            $userBalance = UserBalace::where('user_id', $bisni->user_id)->firstOrFail();
            $server = Server::where('id', $bisni->server_id)->first();
            $username = $bisni->username ?? '';

            if (!empty($username)) {
                $this->routerOsRepository->enablePppSecret($server, $username);
            }
            $bisnis->update([
                'status' => 'aktif',
                'expired' => now()->addMonth(),
            ]);
            Transaction::create([
                'user_id' => $bisni->user_id,
                'amount' => 5000,
                'reference' => 'RTUN' . time(),
                'merchant_ref' => 'RTINV-' . time(),
                'type' => 'Perpanjang Layanan Tunnel',
                'status' => 'PAID',
            ]);
            $userBalance->create([
                'user_id' => $bisni->user_id,
                'balance' => -5000,
            ]);
            Toast::title('Success.')
                ->message('Tunnel berhasil di perpanjang.')
                ->backdrop()
                ->autoDismiss(2);

            return back();
        } catch (ModelNotFoundException $e) {
            // Handle the case where the UserBalance or Server model is not found
            \Log::error("Error renewing Bisnis: Model not found: {$e->getMessage()}");
            abort(404);
        } catch (\Exception $e) {
            // Handle any other errors that may occur
            \Log::error("Error renewing Bisnis: {$e->getMessage()}");
            Toast::title('Error.')
                ->message('Terjadi kesalahan saat memperpanjang bisnis.')
                ->warning()
                ->backdrop()
                ->autoDismiss(2);

            return back();
        }
    }

    public function perpanjang(Bisnis $bisni)
    {
        try {
            $userBalance = UserBalace::where('user_id', $bisni->user_id)->firstOrFail();
            $server = Server::where('id', $bisni->server_id)->first();
            $username = $bisni->username ?? '';

            if (!empty($username)) {
                $this->routerOsRepository->enablePppSecret($server, $username);
            }
            $bisni->update([
                'status' => 'aktif',
                'expired' => now()->addMonth(),
            ]);
            Transaction::create([
                'user_id' => $bisni->user_id,
                'amount' => 5000,
                'reference' => 'RTUN' . time(),
                'merchant_ref' => 'RTINV-' . time(),
                'type' => 'Perpanjang Layanan Tunnel',
                'status' => 'PAID',
            ]);
            $userBalance->create([
                'user_id' => $bisni->user_id,
                'balance' => -5000,
            ]);
            Toast::title('Success.')
                ->message('Tunnel berhasil di perpanjang.')
                ->backdrop()
                ->autoDismiss(2);

            return back();
        } catch (ModelNotFoundException $e) {
            // Handle the case where the UserBalance or Server model is not found
            \Log::error("Error renewing Bisnis: Model not found: {$e->getMessage()}");
            abort(404);
        } catch (\Exception $e) {
            // Handle any other errors that may occur
            \Log::error("Error renewing Bisnis: {$e->getMessage()}");
            Toast::title('Error.')
                ->message('Terjadi kesalahan saat memperpanjang bisnis.')
                ->warning()
                ->backdrop()
                ->autoDismiss(2);

            return back();
        }
    }


    
    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws BadCredentialsException
     * @throws QueryException
     * @throws ConfigException
     */
    public function portTambah(Request $request,Bisnis $bisni)
    {
        
        
        // $server = Bisnis::where('id', $request->server_id)->first();
        
        $existing_to_port = Port::pluck('to_port')->toArray();
        
        $server = Server::where('id', $bisni->server_id)->first();
        

        $pakets = Server::with('paket')->where('id', $bisni->server_id)->first();
        // dd();
        
        // $cek = $this->routerOsRepository->cekPort($server,$request->to_port) ;
        // // $results = preg_match('#dst-port=([^,]+),#', $cek);
        // // dd($cek[0]['dst-port']);
        // $existing_to_port=null;
        // if($cek > 0 )
        // {
        //     $existing_to_port=$cek[0]['dst-port'];
        // }else{

        //     $existing_to_port=null;
        // }
        $to_port= null;
        
        if($request->to_port == null)
        {

            $to_port = generatePort(4, $existing_to_port);
        }else{
            $to_port = $request->to_port;
        }
        
        $port = $request->port;
        
        
        if($pakets->paket->name == 'Business Starter')
        {

            $maks = Port::where('bisnis_id',$bisni->id)->count();   
            if($maks >= 30 )
            {

                Toast::title('Port  Gagal di tambah.')
                    ->message('Anda Gagal Menambah Port, jumlah port forwarding sudah 30 .')
                    ->backdrop()
                    ->autoDismiss(3);
    
                    return back();
            }else{
    
            try {
                DB::beginTransaction();
            //    dd($request->server_id);
                auth()->user()->port()->create([
                    'label' => $request->label,
                    'port' => $port,
                    'to_port' => $to_port,
                    'bisnis_id' => $bisni->id,
                    'user_id' => $bisni->user_id,
                ]);
                
                // dd($bisni->ip_tunnel);
                $this->routerOsRepository->addFirewallPort($server, $bisni->username,$request->label, $bisni->ip_tunnel, $port, $to_port);
                
    
                DB::commit();
                Toast::title('Port  berhasil di tambah.')
                    ->message('Anda Berhasil Menambah Port .')
                    ->backdrop()
                    ->autoDismiss(3);
    
                return back();
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }

            }
        }else{
         
            try {
            DB::beginTransaction();
            //    dd($request->server_id);
            auth()->user()->port()->create([
                    'label' => $request->label,
                    'port' => $port,
                    'to_port' => $to_port,
                    'bisnis_id' => $bisni->id,
                    'user_id' => $bisni->user_id,
                ]);
                
                // dd($bisni->ip_tunnel);
                $this->routerOsRepository->addFirewallPort($server, $bisni->username,$request->label, $bisni->ip_tunnel, $port, $to_port);
                

                DB::commit();
                Toast::title('Port  berhasil di tambah.')
                    ->message('Anda Berhasil Menambah Port .')
                    ->backdrop()
                    ->autoDismiss(3);

                return back();
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }   
        }      
        
    }

    
    /**
     * Remove the specified resource from storage.
     */
    public function portDestroy($id)
    {
        $port = Port::where('id', $id)->first();
        $bisnis = Bisnis::where('id',$port->bisnis_id)->first();

        $server = Server::where('id', $bisnis->server_id)->first();

        // dd($port);
        // $username = $bisni->username;
        // $pap = $bisni->api;
        // $win = $bisni->winbox;
        // $web = $bisni->web;
        // $this->routerOsRepository->disablePpp($server, $username);
        // $this->routerOsRepository->deletePortApi($server, $pap);
        // $this->routerOsRepository->deletePortWeb($server, $web);
        // $this->routerOsRepository->deletePortWinbox($server, $win);
        // $this->routerOsRepository->deletePppSecret($username, $server);
        // $this->routerOsRepository->deleteActiveSecret($server, $username);
        $this->routerOsRepository->deletePort($server, $port->to_port);
            
        $port->delete();
        Toast::title('Success deleted.')
            ->message('Port berhasil di hapus.')
            ->backdrop()
            ->autoDismiss(2);

        return back();
    }
    


}
