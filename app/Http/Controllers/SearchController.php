<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\Comments;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Melakukan pencarian hashtag pada konten Posts dan Comments.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     *
     * 1. Fungsi ini menerima input pencarian dari form yang dikirimkan user.
     * 2. Mengecek apakah hashtag dimulai dengan tanda `#` dan menambahkannya jika belum ada.
     * 3. Melakukan pencarian di konten postingan (`Posts`) yang mengandung hashtag tersebut.
     * 4. Melakukan pencarian di komentar (`Comments`) yang mengandung hashtag tersebut.
     * 5. Menampilkan hasil pencarian di halaman `hashtag_search_results`.
     */
    public function searchHashtag(Request $request)
    {
        // Ambil input dari form search di navbar
        $hashtag = $request->input('cari');

        // Pastikan hashtag dimulai dengan '#'
        if (strpos($hashtag, '#') !== 0) {
            $hashtag = '#' . $hashtag; // Jika tidak ada '#', tambahkan di depan
        }

        // Pencarian di dalam Posts yang mengandung hashtag tersebut
        $posts = Posts::where('content', 'LIKE', '%' . $hashtag . '%')->get();

        // Pencarian di dalam Comments yang mengandung hashtag tersebut
        $comments = Comments::where('content', 'LIKE', '%' . $hashtag . '%')->get();

        // Mengirim hasil pencarian ke view untuk ditampilkan
        return view('hashtag_search_results', compact('posts', 'comments', 'hashtag'));
    }
}
