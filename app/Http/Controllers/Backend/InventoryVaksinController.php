<?php

namespace App\Http\Controllers\Backend;

use App\Models\InventoryVaksin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryVaksinController extends Controller
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
    public function index()
    {
        $data['page_title'] = 'Inventory';
        $data['data'] = InventoryVaksin::orderBy('created_at', 'desc')->get();

        return view('backend.pages.inventory-vaksin.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(InventoryVaksin $inventoryVaksin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InventoryVaksin $inventoryVaksin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InventoryVaksin $inventoryVaksin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InventoryVaksin $inventoryVaksin)
    {
        //
    }
}
