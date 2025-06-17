<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InterfaceStoreRequest;
use App\Models\InterfaceSite;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InterfaceController extends Controller
{
    public function index():View
    {
        $slides = InterfaceSite::where('type','slide')->get();
        return view('admin.interface',compact('slides'));
    }
    public function store(InterfaceStoreRequest $request):RedirectResponse
    {
       $validated = $request->validated();

        $validated['image'] = $request->hasfile('image')?
            basename($request->file('image')->store('slideImages','public')):null;

        InterfaceSite::create($validated);
        return back()->with('success', 'success');
    }

    public  function  destroy(InterfaceSite $slide):RedirectResponse
    {
        $slide->delete();
        return back()->with('success', 'success');

    }
}
