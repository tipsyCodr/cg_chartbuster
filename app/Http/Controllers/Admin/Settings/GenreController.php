<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $genres = Genre::orderBy('for')->orderBy('name')->get();
        return view('admin.settings.genres', compact('genres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Not needed for modal-based CRUD
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'for' => 'required|string|max:255',
        ]);

        // Optional: Ensure unique name for the same entity
        $exists = Genre::where('name', $request->name)->where('for', $request->for)->first();
        if ($exists) {
            return redirect()->back()->withErrors(['name' => 'Genre already exists for this category.'])->withInput();
        }

        Genre::create([
            'name' => $request->name,
            'for' => $request->for,
        ]);

        return redirect()->route('admin.genres.index')->with('success', 'Genre created successfully.');
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
        // Not needed for modal-based CRUD
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $genre = Genre::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'for' => 'required|string|max:255',
        ]);

        // Optional: Ensure unique name for the same entity (excluding current)
        $exists = Genre::where('name', $request->name)
            ->where('for', $request->for)
            ->where('id', '!=', $id)
            ->first();
        if ($exists) {
            return redirect()->back()->withErrors(['name' => 'Genre already exists for this category.'])->withInput();
        }

        $genre->update([
            'name' => $request->name,
            'for' => $request->for,
        ]);

        return redirect()->route('admin.genres.index')->with('success', 'Genre updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $genre = Genre::findOrFail($id);
        $genre->delete();

        return redirect()->route('admin.genres.index')->with('success', 'Genre deleted successfully.');
    }

}
