<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\Comments;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchHashtag(Request $request)
    {
        $hashtag = $request->input('cari'); // Ambil input dari form search di navbar

        // Pastikan hashtag diawali dengan '#'
        if (strpos($hashtag, '#') !== 0) {
            $hashtag = '#' . $hashtag;
        }

        // Mencari di posts
        $posts = Posts::where('content', 'LIKE', '%' . $hashtag . '%')->get();

        // Mencari di comments
        $comments = Comments::where('content', 'LIKE', '%' . $hashtag . '%')->get();

        // Mengirim hasil pencarian ke view
        return view('hashtag_search_results', compact('posts', 'comments', 'hashtag'));
    }
}
