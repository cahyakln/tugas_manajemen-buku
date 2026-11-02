<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->can('view books'), 403);

        $books = Book::latest()->paginate(10);

        return view('books.index', compact('books'));
    }

    public function create()
    {
        abort_unless(auth()->user()->can('create books'), 403);

        return view('books.create');
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->can('create books'), 403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'year' => 'nullable|integer|min:1000|max:9999',
            'isbn' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Book::create($validated);

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Book $book)
    {
        abort_unless(auth()->user()->can('view books'), 403);

        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        abort_unless(auth()->user()->can('edit books'), 403);

        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        abort_unless(auth()->user()->can('edit books'), 403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'year' => 'nullable|integer|min:1000|max:9999',
            'isbn' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $book->update($validated);

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        abort_unless(auth()->user()->can('delete books'), 403);

        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil dihapus.');
    }
}
