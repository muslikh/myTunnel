<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaketStoreRequest;
use Illuminate\Http\Request;
use App\Models\Paket;
use Illuminate\Support\Str;
use ProtoneMedia\Splade\Facades\Toast;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\QueryBuilder\AllowedFilter;

class PaketController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query->orWhere('name', 'LIKE', "%$value%")
                        ->orWhere('domain', 'LIKE', "%$value%");
                });
            });
        });

        return view('paket.index', [
            'pakets' => SpladeTable::for(Paket::class)
                ->column(
                    'name',
                    sortable: true
                )->withGlobalSearch(columns: ['name', 'harga'])
                ->column('harga')
                ->column('deskripsi')
                ->column('actions')
                ->paginate(5),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pakets = Paket::pluck('id', 'slug', 'name', 'deskripsi')->toArray();

        return view('paket.create', ['pakets' => $pakets]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaketStoreRequest $request)
    {
       $paket = Paket::create([
            'name' => $name = $request->name,
            'slug' => str($name . '-' . Str::random(6))->slug(),
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
        ]);

        // dd($paket);
        Toast::title('Berhasil.')
            ->message('Paket baru berhasil di simpan.')
            ->backdrop()
            ->autoDismiss(2);

        return to_route('paket.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Paket $paket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Paket $paket)
    {
        return view('paket.edit', [
            'paket' => $paket,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaketStoreRequest $request, Paket $paket)
    {
        // dd($paket);
        $paket->update([
            'name' => $request->name,
            'harga' => $paket->harga,
            'slug' => $paket->slug,
            'deskripsi' => $request->deskripsi,
        ]);
        Toast::title('Berhasil.')
            ->message('Data paket berhasil di update.')
            ->backdrop()
            ->autoDismiss(2);

        return to_route('paket.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paket $paket)
    {
        $paket->delete();
        Toast::title('Berhasil.')
            ->message('Data paket berhasil di hapus.')
            ->backdrop()
            ->autoDismiss(2);

        return to_route('paket.index');
    }

    public function getHarga($paket_id) //Request $request
    {
        // dd($paket_id);
        $paket = NULL;

        if ($paket_id) {
            $paket = Paket::where('id', $paket_id)
                // ->orderBy('name') //pluck ignores it anyway
                ->pluck('harga', 'id');
        } else {
            $paket = Paket::whereNotNull('id')
                // ->orderBy('name') //pluck ignores it anyway
                ->pluck('harga', 'id');
        }

        return $paket;
    }
}
