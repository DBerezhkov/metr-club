<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\News;

class NewsController extends Controller
{
    public function index($id){
        $news = News::find($id);
        event('newsHasViewed', $news);
        return view('partner.news.show', [
            'news' => $news,
        ]);
    }
}
