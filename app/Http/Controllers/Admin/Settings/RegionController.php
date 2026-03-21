<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index()
    {
        $regions = Region::orderBy('name')->get();
        return view('admin.settings.regions', compact('regions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:regions,name',
        ]);

        Region::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.regions.index')->with('success', 'Region created successfully.');
    }

    public function update(Request $request, $id)
    {
        $region = Region::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:regions,name,' . $region->id,
        ]);

        $region->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.regions.index')->with('success', 'Region updated successfully.');
    }

    public function destroy($id)
    {
        $region = Region::findOrFail($id);
        $region->delete();

        return redirect()->route('admin.regions.index')->with('success', 'Region deleted successfully.');
    }
}

