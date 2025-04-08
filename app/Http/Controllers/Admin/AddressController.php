<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addresses = Address::get();
        return view('admin.addresses', compact('addresses'));
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
        $validate = $request->validate([
            'address' => 'required|string|max:255'
        ]);

        Address::create($validate);

        return to_route('admin.addresses.index');
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
    public function update(Request $request)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        $address->delete();
        return to_route('admin.addresses.index');
    }

    public function addressesDeleted()
    {
        $addresses = Address::onlyTrashed()->get();
        return view('admin.addresses_deleted', compact('addresses'));
    }

    public function addressesRestore(Address $address)
    {
        $address->restore();
        return to_route('admin.addresses.index');
    }
}
