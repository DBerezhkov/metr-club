<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{

    public function show($slug = 'home')
    {
        $page = Page::ofSlug($slug)->first(); // поиск страницы по slug
        return view('pages.index', compact(['page']));
    }
}
