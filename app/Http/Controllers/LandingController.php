<?php

namespace App\Http\Controllers;

use App\Models\Landing;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function show($slug) {
        $landing = Landing::ofSlug($slug)->first();
        $splitted = false;
        $splitted_title = explode('|', $landing->title);
        $clear_title = implode('', $splitted_title);
        if(count($splitted_title) == 2) {
            $splitted = true;
        }
        return view('landings.index', compact(['landing', 'splitted', 'splitted_title', 'clear_title']));
    }
}
