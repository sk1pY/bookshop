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

        $validated['image'] = $request->hasfile('image')?
            basename($request->file('image')->store('slideImages','public')):null;

        InterfaceSite::create($validated);
        return back()->with('success', 'success');
    }

    public  function  destroy(InterfaceSite $slide)
    {
        $slide->delete();
        return back()->with('success', 'success');

    }
}
