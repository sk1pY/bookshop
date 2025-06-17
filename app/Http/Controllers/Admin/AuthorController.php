<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AuthorStoreRequest;
use App\Models\Author;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        $authors = Author::withCount('books')->orderBy('id', 'asc')->paginate(15);
        return view('admin.authors.index', compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        $authors = Author::get();
        return view('admin.authors.create', compact('authors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AuthorStoreRequest $request):RedirectResponse
    {
        $validated = $request->validated();
        Author:: create($validated);
        return back()->with('success', 'success');
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
    public function update(Request $request, string $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author):RedirectResponse
    {
        $author->delete();
        return back()->with('success', 'success');

    }
}
