<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMasyarakatRequest;
use App\Http\Requests\UpdateMasyarakatRequest;
use App\Models\Pengaduan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class MasyarakatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('pages.masyarakat.index', ['liat' => $request->user()->nik]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('pages.masyarakat.detail');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMasyarakatRequest $request): RedirectResponse
    {
        $request->user()->pengaduans()->create([
            'name' => $request->user()->name,
            'description' => $request->description,
            'image' => $request->image ? $request->file('image')->store('assets/laporan') : null,
            'user_nik' => $request->user()->nik,
        ]);

        Alert::success('Berhasil', 'Pengaduan terkirim');

        return redirect('user/pengaduan');

        // return view('pages.masyarakat.detail', compact('items'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function lihat(): View
    {
        return view('pages.masyarakat.detail', [
            'items' => Pengaduan::query()->get(),
        ]);

    }

    public function show(Pengaduan $pengaduan): View
    {
        $pengaduan->load(['details', 'user', 'tanggapan']);

        return view('pages.masyarakat.show', [
            'item' => $pengaduan,
            'tangap' => $pengaduan->tanggapan,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengaduan $pengaduan): View
    {
        $pengaduan->load(['details', 'user', 'tanggapan']);

        return view('pages.masyarakat.edit', [
            'item' => $pengaduan,
            'tangap' => $pengaduan->tan,
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMasyarakatRequest $request, Pengaduan $pengaduan): RedirectResponse
    {
        // do an update [validasi klik UpdateMasyarakatRequest]
        $pengaduan->update([
            'description' => $request->description,
            'image' => $request->image ? $request->file('image')->store('assets/laporan') : null,
        ]);

        Alert::success('Berhasil', 'Pengaduan terkirim');

        return redirect('user/pengaduan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
