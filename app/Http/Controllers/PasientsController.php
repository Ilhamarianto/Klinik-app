<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Patients;

class PasientsController extends Controller
{
    public function index()
    {
        $patient = Patients::latest()->paginate(5);

        return view('patients.index', compact('patient'));
    }

    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string',
            'phone_number' => 'required|min:12|string|max:15',
            'email' => 'required|email|unique:patients,email',
            'address' => 'required|string',
        ]);

        // Simpan data ke dalam database
        $patient = Patients::create([
            'name' => $validated['name'],
            'phone_number' => $validated['phone_number'],
            'email' => $validated['email'],
            'date_of_birth' => $validated['date_of_birth'],
            'gender' => $validated['gender'],
            'address' => $validated['address'],
        ]);

        if ($patient) {
            return response()->json(['success' => true, 'message' => 'Data berhasil disimpan']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan data'], 500);
        }
    }



    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string',
            'phone_number' => 'required|min:12|string|max:15',
            'email' => 'required|email',
            'address' => 'required|string',
        ]);

        $patient = Patients::findOrFail($id);

        $patient->update($request->all());

        if ($patient) {
            return response()->json(['success' => true, 'message' => 'Data berhasil disimpan']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan data'], 500);
        }
    }


    public function destroy($id)
    {
        $patient = Patients::findOrFail($id);
        $patient->delete();
    }
}
