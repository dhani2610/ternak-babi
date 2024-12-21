<?php

namespace App\Http\Controllers\Backend;

use App\Models\Supplier;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
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
        $data['page_title'] = 'Supplier';
        $data['data'] = Supplier::orderBy('created_at', 'desc')->get();

        return view('backend.pages.supplier.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['page_title'] = 'Tambah Supplier';
        return view('backend.pages.supplier.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = new Supplier();
            $data->nama = $request->nama;
            $data->alamat = $request->alamat;
            $data->no_tlp = $request->no_tlp;
            $data->keterangan = $request->keterangan;
            $data->save();

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('supplier');
        } catch (\Throwable $th) {

            session()->flash('failed', $th->getMessage());
            return redirect()->route('supplier');
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
        $data['page_title'] = 'Supplier';
        $data['supplier'] = Supplier::find($id);

        return view('backend.pages.supplier.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Supplier::find($id);
            $data->nama = $request->nama;
            $data->alamat = $request->alamat;
            $data->no_tlp = $request->no_tlp;
            $data->keterangan = $request->keterangan;
            $data->save();

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('supplier');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('supplier');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = Supplier::find($id);
            $data->delete();

            session()->flash('success', 'Data Berhasil Dihapus!');
            return redirect()->route('supplier');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('supplier');
        }
    }
}
