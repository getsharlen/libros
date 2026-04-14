<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBookRequest;
use App\Http\Requests\Admin\UpdateBookRequest;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse|View
    {
        $books = Book::query()
            ->when($request->filled('q'), fn ($query) => $query->where('judul', 'like', '%'.$request->string('q').'%'))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        if (! $request->expectsJson()) {
            return view('admin.books.index', compact('books'));
        }

        return response()->json($books);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.books.create');
    }

    public function store(StoreBookRequest $request): JsonResponse|RedirectResponse
    {
        $book = Book::create($request->validated());

        if (! $request->expectsJson()) {
            return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan.');
        }

        return response()->json([
            'message' => 'Buku berhasil ditambahkan.',
            'data' => $book,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book, Request $request): JsonResponse|View
    {
        if (! $request->expectsJson()) {
            return view('admin.books.show', compact('book'));
        }

        return response()->json($book);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book): View
    {
        return view('admin.books.edit', compact('book'));
    }

    public function update(UpdateBookRequest $request, Book $book): JsonResponse|RedirectResponse
    {
        $book->update($request->validated());

        if (! $request->expectsJson()) {
            return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diperbarui.');
        }

        return response()->json([
            'message' => 'Buku berhasil diperbarui.',
            'data' => $book,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book, Request $request): JsonResponse|RedirectResponse
    {
        $masihDipinjam = $book->peminjamans()->where('status', 'dipinjam')->exists();

        if ($masihDipinjam) {
            if (! $request->expectsJson()) {
                return back()->withErrors(['book' => 'Buku tidak dapat dihapus karena masih dipinjam.']);
            }

            return response()->json([
                'message' => 'Buku tidak dapat dihapus karena masih dipinjam.',
            ], 422);
        }

        $book->delete();

        if (! $request->expectsJson()) {
            return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus.');
        }

        return response()->json([
            'message' => 'Buku berhasil dihapus.',
        ]);
    }
}
