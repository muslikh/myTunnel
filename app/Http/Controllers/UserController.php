<?php

namespace App\Http\Controllers;

use App\Models\UserBalace;
use App\Repositories\TripayRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaketStoreRequest $request)
    {
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
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaketStoreRequest $request, Paket $paket)
    {
       
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paket $paket)
    {
       
        
    }

    public function getHarga($paket_id) //Request $request
    {
       
        
    }
}
