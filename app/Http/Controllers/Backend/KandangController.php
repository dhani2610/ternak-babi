<?php

namespace App\Http\Controllers\Backend;

use App\Models\Kandang;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KandangController extends Controller
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
        $data['page_title'] = 'Kandang';
        $data['data'] = Kandang::orderBy('created_at', 'desc')->get();

        return view('backend.pages.kandang.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['page_title'] = 'Tambah Kandang';
        return view('backend.pages.kandang.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = new Kandang();
            $data->title = $request->title;
            $data->size = $request->size;
            $data->max_ternak = $request->max_ternak;
            $data->save();

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('kandang');
        } catch (\Throwable $th) {

            session()->flash('failed', $th->getMessage());
            return redirect()->route('kandang');
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
        $data['page_title'] = 'Kandang';
        $data['kandang'] = Kandang::find($id);

        return view('backend.pages.kandang.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Kandang::find($id);
            $data->title = $request->title;
            $data->size = $request->size;
            $data->max_ternak = $request->max_ternak;
            $data->save();

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('kandang');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('kandang');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = Kandang::find($id);
            $data->delete();

            session()->flash('success', 'Data Berhasil Dihapus!');
            return redirect()->route('kandang');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('kandang');
        }
    }
}
