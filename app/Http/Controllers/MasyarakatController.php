<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\Tanggapan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use File;

class MasyarakatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user()->nik;
        // dd($user);

        return view('pages.masyarakat.index', ['liat'=>$user]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
        'description' => 'required',
        'image' => 'required|image|mimes:png,jpg,jpeg',
        ]);

        $nik = Auth::user()->nik;
        $id = Auth::user()->id;
        $name = Auth::user()->name;

        $data = $request->all();
        $data['user_nik']=$nik;
        $data['user_id']=$id;
        $data['name']=$name;
        $data['image'] = $request->file('image')->store('assets/laporan', 'public');



        Alert::success('Berhasil', 'Pengaduan terkirim');
        Pengaduan::create($data);
        return redirect('user/pengaduan');
        
        // return view('pages.masyarakat.detail', compact('items'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function lihat() {


        // $user = Auth::user()->pengaduan()->get();
        $user = Auth::user()->nik;


        $items = Pengaduan::all();

        return view('pages.masyarakat.detail', [
            'items' => $items
        ]);

    }

    public function show($id)
    {
        $item = Pengaduan::with([
        'details', 'user'
        ])->findOrFail($id);

        $tangap = Tanggapan::where('pengaduan_id',$id)->first();

        return view('pages.masyarakat.show',[
        'item' => $item,
        'tangap' => $tangap
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Pengaduan::with([
            'details', 'user'
            ])->findOrFail($id);
    
            $tangap = Tanggapan::where('pengaduan_id',$id)->first();
    
            return view('pages.masyarakat.edit',[
            'item' => $item,
            'tangap' => $tangap
            ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //  $this->validate($request, [
        //     'description' => 'required',
        //     'image'   => 'image|mimes:jpeg,jpg,png|max:2048',
        // ]);
    
        // //get data Blog by ID
        // $pengaduan = Pengaduan::findOrFail($id);
    
        // if($request->file('image') == "") {
        //     $nik = Auth::user()->nik;
        //     $id = Auth::user()->id;
        //     $name = Auth::user()->name;
        
        //     $data = $request->all();
        //     $data['user_nik']=$nik;
        //     $data['user_id']=$id;
        //     $data['name']=$name;

        //     $Pengaduan->update($data);
        //     // $data->update([
        //     //     'description'    => $request->description,
        //     // ]);
    
        // } else {
    
        //     //hapus old image
        //     Storage::disk('local')->delete('assets/laporan', 'public'.$image->image);
    
        //     //upload new image
        //     $image = $request->file('gambar');
        //     $image->storeAs('assets/laporan', 'public', $image->hashName());
    
        //     $image->update([
        //         'description' => $request->description,
        //         'image'  => $image->hashName(),
        //     ]);
    
        // }
        //     return redirect()->route('user.pengaduan')->with(['success' => 'Data Berhasil Diupdate!']);


        $request->validate([
            'description' => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg',
            ]);
    
            $pengaduan = Pengaduan::findOrFail($id);
            $nik = Auth::user()->nik;
            $id = Auth::user()->id;
            $name = Auth::user()->name;
    
            $data = $request->all();
            $data['user_nik']=$nik;
            $data['user_id']=$id;
            $data['name']=$name;
            $data['image'] = $request->file('image')->store('assets/laporan', 'public');
    
    
    
            Alert::success('Berhasil', 'Pengaduan terkirim');
            Pengaduan::update($data);
            // Pengaduan::update($data);
            // Pengaduan::where('id', $id)->update($request->validated());
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
