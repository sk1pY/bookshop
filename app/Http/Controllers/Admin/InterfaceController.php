<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InterfaceSite;
use Illuminate\Http\Request;

class InterfaceController extends Controller
{
    public function index()
    {
        $slides = InterfaceSite::where('type','slide')->get();
        return view('admin.interface',compact('slides'));
    }
    public function store(Request $request)
    {
       $validated = $request->validate([
           'image' => 'required|image|mimes:jpg,png|max:2048',
           'type' => 'required'
       ]);
//
        if ($request->hasFile('image')) {
           $validated['image'] = basename($request->file('image')->store('imageSlide','public'));
       }

        InterfaceSite::create($validated);
        return to_route('admin.interfaces.index');
    }

    public  function  destroy(InterfaceSite $slide)
    {
        $slide->delete();
        return to_route('admin.interfaces.index');

    }
}
