<?php

namespace App\Http\Controllers;

use App\Image as Image;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB as DB;

class GameController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        $limit = 2;
        $images = Image::orderby(DB::raw('RAND()'))->take($limit)->get();
        if (count($images))
        {
           return view('pages.game', compact('images'));
        }
        return redirect('images');
    }
}
