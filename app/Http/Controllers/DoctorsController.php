<?php

namespace App\Http\Controllers;

use App\Models\Doctors;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;


class DoctorsController extends Controller
{
    public function index()
    {
        $doctors = Doctors::latest()->paginate(5);

        return view('doctors.index', compact('doctors'));
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return RedirectResponse
     */

    public function store(Request $request): RedirectResponse
    {

        // Validasi form
        $request->validate([
            'name' => 'required',
            'specialization' => 'required',
            'phone_number' => 'required|min:10|numeric',
            'email' => 'required',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048', // 'nullable' ditambahkan agar image tidak wajib diisi
        ]);



        // Default image path jika tidak ada gambar yang diupload
        $imagePath = 'doctors/default.jpg'; // Pastikan file 'default.jpg' ada di folder 'public/storage/doctors'

        // Menyimpan file gambar jika ada
        if ($request->hasFile('image')) {
            // Ambil file gambar dari request
            $image = $request->file('image');

            // Tentukan nama file dengan timestamp agar unik
            $imageName = time() . '.' . $image->extension();

            // Simpan file ke folder 'doctors' dalam folder 'public'
            $image->storeAs('doctors', $imageName, 'public');

            // Tentukan path gambar untuk disimpan ke database
            $imagePath = 'doctors/' . $imageName;
        }

        // Simpan data ke database
        Doctors::create([
            'name' => $request->input('name'),
            'specialization' => $request->input('specialization'),
            'phone_number' => $request->input('phone_number'),
            'email' => $request->input('email'),
            'image' => $imagePath,
        ]);

        // Redirect setelah berhasil
        return Redirect::route('doctors.index')->with('success', 'Doctor added successfully.');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        // Validasi form
        $request->validate([
            'name' => 'required',
            'specialization' => 'required',
            'phone_number' => 'required|min:10|numeric',
            'email' => 'required',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        // Temukan data dokter berdasarkan ID
        $doctor = Doctors::findOrFail($id);

        // Set path gambar awal dengan gambar yang sudah ada di database
        $imagePath = $doctor->image;

        // Jika ada file gambar yang diupload
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika bukan gambar default
            if ($doctor->image !== 'doctors/default.jpg' && Storage::disk('public')->exists($doctor->image)) {
                Storage::disk('public')->delete($doctor->image);
            }

            // Ambil file gambar baru dari request
            $image = $request->file('image');

            // Tentukan nama file dengan timestamp agar unik
            $imageName = time() . '.' . $image->extension();

            // Simpan file ke folder 'doctors' dalam folder 'public'
            $image->storeAs('doctors', $imageName, 'public');

            // Tentukan path gambar untuk disimpan ke database
            $imagePath = 'doctors/' . $imageName;
        }

        // Update data dokter di database
        $doctor->update([
            'name' => $request->input('name'),
            'specialization' => $request->input('specialization'),
            'phone_number' => $request->input('phone_number'),
            'email' => $request->input('email'),
            'image' => $imagePath,
        ]);

        // Redirect setelah berhasil
        return Redirect::route('doctors.index')->with('success', 'Doctor updated successfully.');
    }

    public function destroy($id)
    {
        // Temukan dokter berdasarkan ID
        $doctor = Doctors::findOrFail($id);

        // Hapus file gambar jika ada
        if ($doctor->image && $doctor->image !== 'doctors/default.jpg') {
            Storage::disk('public')->delete($doctor->image);
        }

        // Hapus data dokter dari database
        $doctor->delete();

        // Kembalikan response JSON dengan pesan sukses
        return response()->json(['success' => 'Doctor deleted successfully.']);
    }
}
