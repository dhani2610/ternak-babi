<?php

namespace App\Http\Controllers\Backend;

use App\Models\Vaksin;
use App\Http\Controllers\Controller;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VaksinController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['page_title'] = 'vaksin';
        $data['data'] = Vaksin::orderBy('created_at', 'desc')->get();

        return view('backend.pages.vaksin.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['page_title'] = 'Tambah Vaksin';
        $data['satuan'] = Satuan::orderBy('created_at', 'desc')->get();

        return view('backend.pages.vaksin.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = new Vaksin();
            $data->nama = $request->nama;
            $data->id_satuan = $request->id_satuan;
            $data->cara_pemakaian = $request->cara_pemakaian;
            $data->dosis = $request->dosis;
            $data->catatan = $request->catatan;
            $data->save();

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('vaksin');
        } catch (\Throwable $th) {

            session()->flash('failed', $th->getMessage());
            return redirect()->route('vaksin');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Vaksin $vaksin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['page_title'] = 'Vaksin';
        $data['vaksin'] = Vaksin::find($id);
        $data['satuan'] = Satuan::orderBy('created_at', 'desc')->get();

        return view('backend.pages.vaksin.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Vaksin::find($id);
            $data->nama = $request->nama;
            $data->id_satuan = $request->id_satuan;
            $data->cara_pemakaian = $request->cara_pemakaian;
            $data->dosis = $request->dosis;
            $data->catatan = $request->catatan;
            $data->save();

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('vaksin');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('vaksin');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = Vaksin::find($id);
            $data->delete();

            session()->flash('success', 'Data Berhasil Dihapus!');
            return redirect()->route('vaksin');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('vaksin');
        }
    }
}
