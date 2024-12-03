<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::all();
        $books = Book::orderBy('created_at', 'desc')->paginate(8);

        return view('admin.authors.index', compact('books', 'authors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authors = Author::all();
        return view('admin.authors.create', compact('authors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|alpha|max:30',
            'surname' => 'required|alpha|max:30',
        ], [
            'name.required' => 'напишите имя автора',
            'surname.required' => 'напишите фамилию автора',
            '*.alpha' => 'только буквы'
        ]);
        Author:: create([
            'name' => $validated['name'],
            'surname' => $validated['surname'],
        ]);

        return redirect()->route('admin.authors.index');
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
    public function destroy(string $id)
    {
        Author::destroy($id);
        return redirect()->route('admin.authors.index');
    }
}
