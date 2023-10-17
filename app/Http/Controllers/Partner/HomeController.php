<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\News;

class HomeController extends Controller
{
    public function index() {
        $news = News::orderBy('created_at', 'desc')->paginate(5);

        return view('partner.home.index', [
            'news' => $news,
        ]);
    }
}
