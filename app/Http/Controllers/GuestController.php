<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Books;

class GuestController extends Controller
{
    public function index()
    {
        $books = Books::all(); // ambil semua data buku
        return view('dashboard.guest', compact('books')); // kirim ke view guest dashboard
    }

    public function indexBooks() {

    }

}
