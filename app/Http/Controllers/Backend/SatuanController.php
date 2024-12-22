<?php

namespace App\Http\Controllers\Backend;

use App\Models\Satuan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class satuanController extends Controller
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
        $data['page_title'] = 'Satuan';
        $data['data'] = Satuan::orderBy('created_at', 'desc')->get();

        return view('backend.pages.satuan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['page_title'] = 'Tambah Satuan';
        return view('backend.pages.satuan.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = new Satuan();
            $data->nama = $request->nama;
            $data->save();

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('satuan');
        } catch (\Throwable $th) {

            session()->flash('failed', $th->getMessage());
            return redirect()->route('satuan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(satuan $satuan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['page_title'] = 'Satuan';
        $data['satuan'] = Satuan::find($id);

        return view('backend.pages.satuan.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Satuan::find($id);
            $data->nama = $request->nama;
            $data->save();

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('satuan');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('satuan');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = Satuan::find($id);
            $data->delete();

            session()->flash('success', 'Data Berhasil Dihapus!');
            return redirect()->route('satuan');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('satuan');
        }
    }
}
