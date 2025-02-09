<?php

namespace App\Http\Controllers\Backend;

use App\Models\PenggunaanVaksin;
use App\Http\Controllers\Controller;
use App\Models\InventoryVaksin;
use App\Models\Vaksin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenggunaanVaksinController extends Controller
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
        $data['page_title'] = 'Penggunaan Pakan';
        $data['data'] = PenggunaanVaksin::orderBy('created_at', 'desc')->get();

        return view('backend.pages.penggunaan.vaksin.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['page_title'] = 'Tambah Penggunaan Vaksin';
        $data['vaksin'] = Vaksin::orderBy('created_at', 'desc')->get();

        return view('backend.pages.penggunaan.vaksin.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = new PenggunaanVaksin();
            $data->id_vaksin = $request->id_vaksin;
            $data->jumlah = $request->jumlah;
            $data->tanggal = $request->tanggal;
            $data->catatan = $request->catatan;
            $cekVaksin = Vaksin::where('id',$request->id_vaksin)->first();

            if ($data->save()) {
                $cekInventory = InventoryVaksin::where('id_vaksin',$data->id_vaksin)->first();
                if ($cekInventory != null) {
                    if ($cekInventory->qty_now < $data->jumlah) {
                        $data->delete();
                        session()->flash('failed', 'Gagal! stok vaksin tersisa '.$cekInventory->qty_now);
                        return redirect()->route('penggunaan-vaksin');
                    }

                    $update = InventoryVaksin::find($cekInventory->id);
                    $kurang = $update->qty_now - $data->jumlah;
                    if ($kurang < 0) {
                        $final = 0;
                    }else{
                        $final = $kurang;
                    }
                    $update->qty_now = $final;
                    $update->save();
                }else{
                    $data->delete();
                    session()->flash('failed', 'Vaksin tidak tersedia!');
                    return redirect()->route('penggunaan-vaksin');
                }
            }
            

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('penggunaan-vaksin');
        } catch (\Throwable $th) {

            session()->flash('failed', $th->getMessage());
            return redirect()->route('penggunaan-vaksin');
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
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = PenggunaanVaksin::find($id);

            if ($data->save()) {
                $cekInventory = InventoryVaksin::where('id_vaksin',$data->id_vaksin)->first();
                if ($cekInventory != null) {
                    $update = InventoryVaksin::find($cekInventory->id);
                    $kurang = $update->qty_now + $data->jumlah;
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
            return redirect()->route('penggunaan-vaksin');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('penggunaan-vaksin');
        }
    }
}
