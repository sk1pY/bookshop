<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryAddress;
use Illuminate\Http\Request;

class AddressesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addresses = DeliveryAddress::all();
        return view('admin.addresses',compact('addresses'));
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
        DeliveryAddress::create([
            'address' => $request->input('address'),
        ]);

        return redirect()->route('admin.addresses.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,DeliveryAddress $address)
    {
        $address->update([
            'address' => $request->input('address'),
        ]);

        return redirect()->route('admin.addresses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeliveryAddress $address)
    {
        $address->delete();

        return redirect()->route('admin.addresses.index');
    }
}
