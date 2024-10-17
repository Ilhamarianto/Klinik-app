<?php

namespace App\Http\Controllers;

use App\Models\Nurses;
// use Illuminate\Container\Attributes\Storage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NursesController extends Controller
{
    public function index()
    {

        $nurses = Nurses::latest()->paginate(5);

        return view('nurses.index', compact('nurses'));
    }

    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Default image path jika tidak ada gambar yang diupload
        $imagePath = 'nurses_images/default.png'; // Pastikan file 'default.jpg' ada di folder 'public/storage/nurses'

        // Menyimpan file gambar jika ada
        if ($request->hasFile('image')) {
            // Ambil file gambar dari request
            $image = $request->file('image');

            // Tentukan nama file dengan timestamp agar unik
            $imageName = time() . '.' . $image->extension();

            // Simpan file ke folder 'nurses' dalam folder 'public'
            $image->storeAs('nurses', $imageName, 'public');

            // Tentukan path gambar untuk disimpan ke database
            $imagePath = 'nurses_images/' . $imageName;
        }

        // Simpan data ke database
        $nurse = Nurses::create([
            'name' => $validated['name'],
            'phone_number' => $validated['phone_number'],
            'email' => $validated['email'],
            'image' => $imagePath, // Simpan path gambar, default atau yang diunggah
        ]);

        // Cek apakah data berhasil disimpan
        if ($nurse) {
            return response()->json(['success' => true, 'message' => 'Data berhasil disimpan']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan data'], 500);
        }
    }


    public function update(Request $request, $id)
    {
        // Validasi data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Cari data nurse berdasarkan ID
        $nurse = Nurses::findOrFail($id);

        // Menyimpan file gambar jika ada
        if ($request->hasFile('image')) {
            // Ambil file gambar dari request
            $image = $request->file('image');

            // Tentukan nama file baru dengan timestamp agar unik
            $imageName = time() . '.' . $image->extension();

            // Hapus gambar lama jika bukan gambar default
            if ($nurse->image && $nurse->image !== 'nurses_images/default.png') {
                $oldImagePath = public_path('storage/' . $nurse->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // Menghapus file lama
                }
            }

            // Simpan file baru ke folder 'nurses' dalam folder 'public/storage'
            $image->storeAs('nurses_images', $imageName, 'public');

            // Tentukan path gambar untuk disimpan ke database
            $imagePath = 'nurses_images/' . $imageName;

            // Perbarui path gambar pada data nurse
            $nurse->image = $imagePath;
        }

        // Update data lainnya
        $nurse->name = $validated['name'];
        $nurse->phone_number = $validated['phone_number'];
        $nurse->email = $validated['email'];
        $nurse->save();

        // Mengembalikan respons JSON untuk AJAX
        return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui']);
    }




    public function destroy($id)
    {
        try {
            // Temukan nurse berdasarkan ID
            $nurse = Nurses::findOrFail($id);

            // Hapus file gambar jika ada
            if ($nurse->image && $nurse->image !== 'nurses_images/default.png') {
                Storage::disk('public')->delete($nurse->image);
            }

            // Hapus data nurse dari database
            $nurse->delete();

            return response()->json(['success' => 'Nurse deleted successfully.']);
        } catch (\Exception $e) {
            Log::error('Error deleting nurse: ' . $e->getMessage());
            return response()->json(['error' => 'There was an error deleting the nurse.'], 500);
        }
    }
}
