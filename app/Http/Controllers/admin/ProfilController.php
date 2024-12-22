<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Gunakan model User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    // Menampilkan halaman profil admin
    public function show()
    {
        return view('admin.profil');
    }

    // Menampilkan halaman edit profil admin
    public function edit()
    {
        return view('admin.edit_profil');
    }

    // Mengupdate profil admin
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::guard('admin')->id(), // Menggunakan guard admin
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|confirmed',
        ]);

        // Ambil data admin menggunakan Auth guard admin
        $admin = User::find(Auth::guard('admin')->id());

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/admin'), $filename);

            // Delete old profile picture if exists
            if ($admin->profile_picture) {
                $oldPath = public_path('uploads/admin/' . $admin->profile_picture);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $admin->profile_picture = $filename;
        }

        // Update nama dan email admin
        $admin->name = $request->input('name');
        $admin->email = $request->input('email');

        // Update password jika diisi
        if ($request->filled('password')) {
            $admin->password = bcrypt($request->input('password'));
        }

        // Simpan perubahan
        $admin->save();

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully!');
    }
}
