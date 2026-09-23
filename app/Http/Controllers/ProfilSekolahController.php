<?php

namespace App\Http\Controllers;

use App\Models\ProfilSekolah;
use App\Http\Requests\StoreProfilSekolahRequest;
use App\Http\Requests\UpdateProfilSekolahRequest;

class ProfilSekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => 'Profil Sekolah'
        ];

        return view('admin.profil', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProfilSekolahRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProfilSekolah $profilSekolah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProfilSekolah $profilSekolah)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfilSekolahRequest $request, ProfilSekolah $profilSekolah)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProfilSekolah $profilSekolah)
    {
        //
    }
}
