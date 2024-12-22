<?php

namespace App\Http\Controllers\Backend;

use App\Models\MixPakan;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\MixPakanDetail;
use App\Models\Pakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MixPakanController extends Controller
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
        $data['data'] = MixPakan::orderBy('created_at', 'desc')->get();
        $data['count'] = MixPakanDetail::orderBy('created_at', 'desc')->get()->sum('qty');

        return view('backend.pages.mix-pakan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['page_title'] = 'Tambah Mix Pakan';
        $data['pakan'] = Inventory::where('qty_now','>',0)->orderBy('created_at', 'desc')->get();
        return view('backend.pages.mix-pakan.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Simpan data ke tabel mix_pakans
            $mixPakan = new MixPakan();
            $mixPakan->title = $request->title;
            $mixPakan->total_harga = array_sum($request->total);
            $mixPakan->save();

            // Simpan data ke tabel mix_pakan_details
            $idPakans = $request->id_pakan;
            $qtys = $request->qty;
            $prices = $request->price;
            $totals = $request->total;

            foreach ($idPakans as $index => $idPakan) {
                $detail = new MixPakanDetail();
                $detail->id_mix = $mixPakan->id;
                $detail->id_pakan = $idPakan;
                $detail->qty = $qtys[$index];
                $detail->price = $prices[$index];
                $detail->total = $totals[$index];
                $detail->save();

                $cekInventory = Inventory::where('id_pakan',$idPakan)->first();
                if ($cekInventory != null) {
                    $update = Inventory::find($cekInventory->id);
                    $update->qty_now = $update->qty_now - $qtys[$index];
                    $update->save();
                }
            }

            DB::commit();
            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('mix-pakan');
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('failed', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back()->withInput();
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

        return view('backend.pages.mix-pakan.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Pakan::find($id);
            $data->nama_pakan = $request->nama_pakan;
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
        DB::beginTransaction();

        try {
            // Cari data mix pakan berdasarkan ID
            $mixPakan = MixPakan::findOrFail($id);

            // Ambil semua detail pakan terkait
            $details = MixPakanDetail::where('id_mix', $id)->get();

            // Loop untuk mengembalikan qty ke inventory
            foreach ($details as $detail) {
                $idPakan = $detail->id_pakan;
                $qty = $detail->qty;

                // Cek apakah pakan ada di inventory
                $cekInventory = Inventory::where('id_pakan', $idPakan)->first();
                if ($cekInventory != null) {
                    $cekInventory->qty_now = $cekInventory->qty_now + $qty;
                    $cekInventory->save();
                }

                // Hapus detail pakan
                $detail->delete();
            }

            // Hapus mix pakan
            $mixPakan->delete();

            DB::commit();
            session()->flash('success', 'Data Berhasil Dihapus!');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('failed', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}