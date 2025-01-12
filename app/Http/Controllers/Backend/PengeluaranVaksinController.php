<?php

namespace App\Http\Controllers\Backend;

use App\Models\PengeluaranVaksin;
use App\Http\Controllers\Controller;
use App\Models\InventoryVaksin;
use App\Models\Supplier;
use App\Models\Vaksin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengeluaranVaksinController extends Controller
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
        $data['data'] = PengeluaranVaksin::orderBy('created_at', 'desc')->get();

        return view('backend.pages.pengeluaran.vaksin.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['page_title'] = 'Tambah Pengeluaran Vaksin';
        $data['vaksin'] = Vaksin::orderBy('created_at', 'desc')->get();
        $data['supplier'] = Supplier::orderBy('created_at', 'desc')->get();

        return view('backend.pages.pengeluaran.vaksin.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = new PengeluaranVaksin();
            $data->title = $request->title;
            $data->id_vaksin = $request->id_vaksin;
            $data->qty = $request->qty;
            $data->price = $request->price;
            $data->tanggal_pembelian = $request->tanggal_pembelian;
            $data->tanggal_pengiriman = $request->tanggal_pengiriman;
            $data->id_supplier = $request->id_supplier;

            $cekVaksin = Vaksin::where('id',$request->id_vaksin)->first();

            if ($data->save()) {
                $inv = new InventoryVaksin();
                $inv->id_vaksin = $request->id_vaksin;
                $inv->qty_now = $request->qty;
                $inv->min_qty = 0;
                $inv->price = $request->price;
                $inv->save();
            }
            

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('pengeluaran-vaksin');
        } catch (\Throwable $th) {

            session()->flash('failed', $th->getMessage());
            return redirect()->route('pengeluaran-vaksin');
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
            $data = PengeluaranVaksin::find($id);

            if ($data->save()) {
                $cekInventory = InventoryVaksin::where('id_vaksin',$data->id_vaksin)->first();
                if ($cekInventory != null) {
                    $update = InventoryVaksin::find($cekInventory->id);
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
            return redirect()->route('pengeluaran-vaksin');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('pengeluaran-vaksin');
        }
    }
}
