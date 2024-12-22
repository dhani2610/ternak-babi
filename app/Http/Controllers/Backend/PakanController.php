<?php

namespace App\Http\Controllers\Backend;

use App\Models\Pakan;
use App\Http\Controllers\Controller;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PakanController extends Controller
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
        $data['page_title'] = 'Pakan';
        $data['data'] = Pakan::orderBy('created_at', 'desc')->get();

        return view('backend.pages.pakan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['page_title'] = 'Tambah Pakan';
        $data['satuan'] = Satuan::orderBy('created_at', 'desc')->get();

        return view('backend.pages.pakan.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = new Pakan();
            $data->nama_pakan = $request->nama_pakan;
            $data->satuan = 'Kg';
            $data->save();

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('pakan');
        } catch (\Throwable $th) {

            session()->flash('failed', $th->getMessage());
            return redirect()->route('pakan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pakan $pakan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['page_title'] = 'Pakan';
        $data['pakan'] = Pakan::find($id);
        $data['satuan'] = Satuan::orderBy('created_at', 'desc')->get();

        return view('backend.pages.pakan.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Pakan::find($id);
            $data->nama_pakan = $request->nama_pakan;
            $data->satuan = 'Kg';
            $data->save();

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('pakan');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('pakan');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = Pakan::find($id);
            $data->delete();

            session()->flash('success', 'Data Berhasil Dihapus!');
            return redirect()->route('pakan');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('pakan');
        }
    }
}
