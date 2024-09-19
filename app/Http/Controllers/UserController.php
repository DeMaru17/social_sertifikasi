<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        return view('user.index', compact('user', 'posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    // UserController.php

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // Check if the old password is correct
        if ($request->filled('old_password') && $request->filled('new_password')) {
            if (!Hash::check($request->old_password, $user->password)) {
                Alert::warning('Password lama salah', 'Silahkan cek kembali password lama anda');
                return back()->withErrors(['old_password' => 'Password lama tidak sesuai']);
            }
        }

        if ($request->hasFile('profile_picture')) {
            // Hapus gambar lama jika ada:
            if ($user->profile_picture) {
                Storage::delete('public/image/' . $user->profile_picture);
            }
            $image = $request->file('profile_picture');
            $path = $image->store('image','public');
            $name = basename($path);
            $user->profile_picture = $name;
        }

        // Only update the password if the new password is filled
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        $user->bio = $request->input('bio');

        $user->save();

        Alert::success('Success', 'Data berhasil diperbarui');

        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function showProfile()
    {
        $user = Auth::user();
        $posts = Posts::where('id_user', $user->id)->get();
        return view('user.index', compact('user', 'posts'));
    }
}
