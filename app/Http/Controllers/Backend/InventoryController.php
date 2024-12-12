<?php

namespace App\Http\Controllers\Backend;

use App\Models\Inventory;
use App\Http\Controllers\Controller;
use App\Models\Pakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
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
        $data['page_title'] = 'Inventory';
        $data['data'] = Inventory::orderBy('created_at', 'desc')->get();

        return view('backend.pages.inventory.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['page_title'] = 'Tambah Inventory';
        $data['pakan'] = Pakan::orderBy('created_at', 'desc')->get();

        return view('backend.pages.inventory.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = new Inventory();
            $data->id_pakan = $request->id_pakan;
            $data->qty_now = $request->qty_now;
            $data->min_qty = $request->min_qty;
            $data->price = $request->price;
            $data->satuan = $request->satuan;
            $data->save();

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('inventory');
        } catch (\Throwable $th) {

            session()->flash('failed', $th->getMessage());
            return redirect()->route('inventory');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $Inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['page_title'] = 'Inventory';
        $data['inventory'] = Inventory::find($id);
        $data['pakan'] = Pakan::orderBy('created_at', 'desc')->get();

        return view('backend.pages.inventory.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Inventory::find($id);
            $data->id_pakan = $request->id_pakan;
            $data->qty_now = $request->qty_now;
            $data->min_qty = $request->min_qty;
            $data->price = $request->price;
            $data->satuan = $request->satuan;
            $data->save();

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('inventory');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('inventory');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = Inventory::find($id);
            $data->delete();

            session()->flash('success', 'Data Berhasil Dihapus!');
            return redirect()->route('inventory');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('inventory');
        }
    }
}
