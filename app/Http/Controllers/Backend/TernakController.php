<?php

namespace App\Http\Controllers\Backend;

use App\Models\Ternak as Pig;
use App\Http\Controllers\Controller;
use App\Models\Kandang;
use App\Models\MixPakan;
use App\Models\MixPakanDetail;
use App\Models\Pakan;
use App\Models\PenggunaanPakan;
use Illuminate\Http\Request;

class TernakController extends Controller
{
    public function index()
    {
        $data['page_title'] = 'Daftar Ternak';
        $data['data'] = Pig::orderBy('created_at', 'desc')->get();
        return view('backend.pages.ternak.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Tambah Ternak';
        $data['kandang'] = Kandang::orderBy('created_at', 'desc')->get();

        return view('backend.pages.ternak.create', $data);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'tag_number' => 'required',
            'gender' => 'required|string',
            'date_birthday' => 'required|date',
            'is_breeding_stok' => 'required',
            'date_delivered_to_farm' => 'required|date',
            'photo1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo4' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Nama harus diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
    
            'tag_number.required' => 'Nomor tag harus diisi.',
    
            'gender.required' => 'Jenis kelamin harus diisi.',
            'gender.string' => 'Jenis kelamin harus berupa teks.',
    
            'date_birthday.required' => 'Tanggal lahir harus diisi.',
            'date_birthday.date' => 'Tanggal lahir harus berupa format tanggal yang valid.',
    
            'is_breeding_stok.required' => 'Status breeding stock harus diisi.',
            'is_breeding_stok.boolean' => 'Status breeding stock harus berupa nilai benar (true) atau salah (false).',
    
            'date_delivered_to_farm.required' => 'Tanggal pengiriman ke peternakan harus diisi.',
            'date_delivered_to_farm.date' => 'Tanggal pengiriman harus berupa format tanggal yang valid.',
    
            'photo1.image' => 'Photo 1 harus berupa gambar.',
            'photo1.mimes' => 'Photo 1 harus memiliki format jpeg, png, jpg, atau gif.',
            'photo1.max' => 'Ukuran Photo 1 tidak boleh lebih dari 2MB.',
    
            'photo2.image' => 'Photo 2 harus berupa gambar.',
            'photo2.mimes' => 'Photo 2 harus memiliki format jpeg, png, jpg, atau gif.',
            'photo2.max' => 'Ukuran Photo 2 tidak boleh lebih dari 2MB.',
    
            'photo3.image' => 'Photo 3 harus berupa gambar.',
            'photo3.mimes' => 'Photo 3 harus memiliki format jpeg, png, jpg, atau gif.',
            'photo3.max' => 'Ukuran Photo 3 tidak boleh lebih dari 2MB.',
    
            'photo4.image' => 'Photo 4 harus berupa gambar.',
            'photo4.mimes' => 'Photo 4 harus memiliki format jpeg, png, jpg, atau gif.',
            'photo4.max' => 'Ukuran Photo 4 tidak boleh lebih dari 2MB.',
        ]);

        try {
            $pig = new Pig();
            $pig->name = $request->name;
            $pig->tag_number = $request->tag_number;
            $pig->gender = $request->gender;
            $pig->date_birthday = $request->date_birthday;
            $pig->is_full_breed = $request->is_full_breed ?? 0;
            $pig->breed = $request->breed;
            $pig->is_breeding_stok = $request->is_breeding_stok;
            $pig->pig_pen = $request->pig_pen;
            $pig->comment = $request->comment;
            $pig->father_tag = $request->father_tag;
            $pig->mother_tag = $request->mother_tag;
            $pig->weight = $request->weight;
            $pig->height = $request->height;
            $pig->color = $request->color;
            $pig->purchase_date = $request->purchase_date;
            $pig->purchased_from = $request->purchased_from;
            $pig->date_delivered_to_farm = $request->date_delivered_to_farm;
            $pig->purchase_price = $request->purchase_price;
            $pig->status = 'active';

            // Upload Foto
            $no = 1; // Untuk penomoran nama file
            foreach (['photo1', 'photo2', 'photo3', 'photo4'] as $photoField) {
                if ($request->hasFile($photoField)) {
                    $image = $request->file($photoField);
                    $name = $no++ . '-' . time() . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('assets/img/pig_photos/');
                    $image->move($destinationPath, $name);
                    $pig->$photoField = $name;
                }
            }

            $pig->save();

            return redirect()->route('ternak')->with('success', 'Data Berhasil Disimpan!');
        } catch (\Throwable $th) {
            return redirect()->route('ternak')->with('failed', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Ternak';
        $data['pig'] = Pig::findOrFail($id);
        $data['kandang'] = Kandang::orderBy('created_at', 'desc')->get();
        return view('backend.pages.ternak.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'tag_number' => 'required',
            'gender' => 'required|string',
            'date_birthday' => 'required|date',
            'is_breeding_stok' => 'required',
            'date_delivered_to_farm' => 'required|date',
            'photo1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo4' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Nama harus diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
    
            'tag_number.required' => 'Nomor tag harus diisi.',
    
            'gender.required' => 'Jenis kelamin harus diisi.',
            'gender.string' => 'Jenis kelamin harus berupa teks.',
    
            'date_birthday.required' => 'Tanggal lahir harus diisi.',
            'date_birthday.date' => 'Tanggal lahir harus berupa format tanggal yang valid.',
    
            'is_breeding_stok.required' => 'Status breeding stock harus diisi.',
            'is_breeding_stok.boolean' => 'Status breeding stock harus berupa nilai benar (true) atau salah (false).',
    
            'date_delivered_to_farm.required' => 'Tanggal pengiriman ke peternakan harus diisi.',
            'date_delivered_to_farm.date' => 'Tanggal pengiriman harus berupa format tanggal yang valid.',
    
            'photo1.image' => 'Photo 1 harus berupa gambar.',
            'photo1.mimes' => 'Photo 1 harus memiliki format jpeg, png, jpg, atau gif.',
            'photo1.max' => 'Ukuran Photo 1 tidak boleh lebih dari 2MB.',
    
            'photo2.image' => 'Photo 2 harus berupa gambar.',
            'photo2.mimes' => 'Photo 2 harus memiliki format jpeg, png, jpg, atau gif.',
            'photo2.max' => 'Ukuran Photo 2 tidak boleh lebih dari 2MB.',
    
            'photo3.image' => 'Photo 3 harus berupa gambar.',
            'photo3.mimes' => 'Photo 3 harus memiliki format jpeg, png, jpg, atau gif.',
            'photo3.max' => 'Ukuran Photo 3 tidak boleh lebih dari 2MB.',
    
            'photo4.image' => 'Photo 4 harus berupa gambar.',
            'photo4.mimes' => 'Photo 4 harus memiliki format jpeg, png, jpg, atau gif.',
            'photo4.max' => 'Ukuran Photo 4 tidak boleh lebih dari 2MB.',
        ]);
        try {
            $pig = Pig::findOrFail($id);
            $pig->name = $request->name;
            $pig->tag_number = $request->tag_number;
            $pig->gender = $request->gender;
            $pig->date_birthday = $request->date_birthday;
            $pig->is_full_breed = $request->is_full_breed ?? 0;
            $pig->breed = $request->breed;
            $pig->is_breeding_stok = $request->is_breeding_stok;
            $pig->pig_pen = $request->pig_pen;
            $pig->comment = $request->comment;
            $pig->father_tag = $request->father_tag;
            $pig->mother_tag = $request->mother_tag;
            $pig->weight = $request->weight;
            $pig->height = $request->height;
            $pig->color = $request->color;
            $pig->purchase_date = $request->purchase_date;
            $pig->purchased_from = $request->purchased_from;
            $pig->date_delivered_to_farm = $request->date_delivered_to_farm;
            $pig->purchase_price = $request->purchase_price;

            $no = 1;
            foreach (['photo1', 'photo2', 'photo3', 'photo4'] as $photoField) {
                if ($request->hasFile($photoField)) {
                    $image = $request->file($photoField);
                    $name = $no++ . '-' . time() . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('assets/img/pig_photos/');
                    $image->move($destinationPath, $name);
                    $pig->$photoField = $name;
                }
            }

            $pig->save();

            return redirect()->route('ternak')->with('success', 'Data Berhasil Diperbarui!');
        } catch (\Throwable $th) {
            return redirect()->route('ternak')->with('failed', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $pig = Pig::findOrFail($id);
            $pig->delete();
            return redirect()->route('ternak')->with('success', 'Data Berhasil Dihapus!');
        } catch (\Throwable $th) {
            return redirect()->route('ternak')->with('failed', $th->getMessage());
        }
    }

    public function pakan($id)
    {
        $data['page_title'] = 'History Pakan';
        $data['pig'] = Pig::findOrFail($id);
        $data['pakan'] = Pakan::orderBy('created_at', 'desc')->get();
        $data['count'] = $this->sisaPakan();
        $data['pakan_use'] = PenggunaanPakan::where('id_ternak',$id)->get();
        return view('backend.pages.ternak.pakan', $data);
    }

    public function storePakan(Request $request,$id){
        try {
            if ($request->qty > $this->sisaPakan()) {
                session()->flash('failed', 'Quantity melebihi stok!');
                return redirect()->back();
            }
            $data = new PenggunaanPakan();
            $data->id_ternak = $id;
            $data->tanggal = $request->tanggal;
            $data->qty = $request->qty;
            $data->catatan = $request->catatan;
            $data->save();

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->back();
        } catch (\Throwable $th) {

            session()->flash('failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function sisaPakan(){
        $pakan = MixPakanDetail::orderBy('created_at', 'desc')->get()->sum('qty');
        $use = PenggunaanPakan::get()->sum('qty');
        return $pakan > 0 ? $pakan - $use : 0; 
    }

}
