<?php

namespace App\Http\Controllers;

use App\Models\Treatments;
use Illuminate\Http\Request;

class TreatmentsController extends Controller
{
    public function index()
    {
        $treatments = Treatments::all();
        return view('treatments.index', compact('treatments'));
    }

    public function create()
    {
        return view('treatments.create');
    }

    public function store(Request $request)
    {
        // Validasi data dari request
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:treatments,name',
            'description' => 'nullable|string',
            'cost' => 'required|numeric|min:0',
        ]);

        // Membuat treatment baru dengan data yang telah divalidasi
        Treatments::create($validated);

        return redirect()->route('treatments.index')->with('success', 'Treatment created successfully.');
    }

    public function show(Treatments $treatment)
    {
        return view('treatments.show', compact('treatment'));
    }

    public function edit($id)
    {
        $treatment = Treatments::findOrFail($id);
        return view('treatments.edit', compact('treatment'));
    }

    public function update(Request $request, Treatments $treatment)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:treatments,name,' . $treatment->id,
            'description' => 'nullable|string',
            'cost' => 'required|numeric|min:0',
        ]);

        // Update data treatment yang ada
        $treatment->update($validated);

        // Redirect dengan pesan sukses
        return redirect()->route('treatments.index')->with('success', 'Treatment updated successfully.');
    }

    public function destroy(Treatments $treatment)
    {
        $treatment->delete();

        return redirect()->route('treatments.index')
            ->with('success', 'Treatment deleted successfully.');
    }
}
