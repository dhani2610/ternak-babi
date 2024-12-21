<?php

namespace App\Http\Controllers\Backend;

use App\Models\PengeluaranPakan;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Pakan;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengeluaranPakanController extends Controller
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
        $data['page_title'] = 'Pengeluaran Pakan';
        $data['data'] = PengeluaranPakan::orderBy('created_at', 'desc')->get();

        return view('backend.pages.pengeluaran.pakan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['page_title'] = 'Tambah Pengeluaran Pakan';
        $data['pakan'] = Pakan::orderBy('created_at', 'desc')->get();
        $data['supplier'] = Supplier::orderBy('created_at', 'desc')->get();

        return view('backend.pages.pengeluaran.pakan.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // dd($request->all());
            $data = new PengeluaranPakan();
            $data->title = $request->title;
            $data->id_pakan = $request->id_pakan;
            $data->qty = $request->qty;
            $data->price = $request->price;
            $data->tanggal_pembelian = $request->tanggal_pembelian;
            $data->tanggal_pengiriman = $request->tanggal_pengiriman;
            $data->id_supplier = $request->id_supplier;

            $cekPakan = Pakan::where('id',$request->id_pakan)->first();

            if ($data->save()) {
                $cekInventory = Inventory::where('id_pakan',$request->id_pakan)->first();
                if ($cekInventory != null) {
                    $update = Inventory::find($cekInventory->id);
                    $update->qty_now = $update->qty_now + $request->qty;
                    $update->price = $this->avgPrice($update->id_pakan);
                    $update->satuan = $cekPakan->satuan ?? '-';
                    $update->save();
                }else{
                    $inv = new Inventory();
                    $inv->id_pakan = $request->id_pakan;
                    $inv->qty_now = $request->qty;
                    $inv->min_qty = 0;
                    $inv->price = $request->price;
                    $inv->satuan = $cekPakan->satuan ?? '-';
                    $inv->save();
                }
            }
            

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('pengeluaran-pakan');
        } catch (\Throwable $th) {

            session()->flash('failed', $th->getMessage());
            return redirect()->route('pengeluaran-pakan');
        }
    }

    public function avgPrice($id_pakan)
    {
        try {
            $data = PengeluaranPakan::where('id_pakan', $id_pakan)->pluck('price');

            // Menghitung rata-rata jika data tidak kosong
            if ($data->count() > 0) {
                return $data->avg();
            }

            return 0;
        } catch (\Throwable $th) {
            return 'error';
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
        $data['page_title'] = 'Edit Pengeluaran Pakan';
        $data['pengeluaran-pakan'] = PengeluaranPakan::find($id);
        $data['pakan'] = Pakan::orderBy('created_at', 'desc')->get();

        return view('backend.pages.pengeluaran.pakan.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = PengeluaranPakan::find($id);
            $data->title = $request->title;
            $data->id_pakan = $request->id_pakan;
            $data->qty = $request->qty;
            $data->price = $request->price;
            $data->tanggal_pembelian = $request->tanggal_pembelian;
            $data->tanggal_pengiriman = $request->tanggal_pengiriman;
            $data->save();
            

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('pengeluaran-pakan');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('pengeluaran-pakan');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = PengeluaranPakan::find($id);

            if ($data->save()) {
                $cekInventory = Inventory::where('id_pakan',$data->id_pakan)->first();
                if ($cekInventory != null) {
                    $update = Inventory::find($cekInventory->id);
                    $kurang = $update->qty_now - $data->qty;
                    if ($kurang < 0) {
                        $final = 0;
                    }else{
                        $final = $kurang;
                    }
                    $update->qty_now = $final;
                    $update->save();
                }
            }

            $data->delete();

            session()->flash('success', 'Data Berhasil Dihapus!');
            return redirect()->route('pengeluaran-pakan');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('pengeluaran-pakan');
        }
    }
}
