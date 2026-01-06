<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Pastikan Model User di-import
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Menampilkan daftar pengguna.
     */
    public function index()
    {
        // 1. Ambil data user dari database
        $users = User::latest()->paginate(10);

        // 2. Kirim variabel $users ke View menggunakan compact()
        return view('admin.users.index', compact('users'));
    }
}