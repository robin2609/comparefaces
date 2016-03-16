<?php

namespace App\Http\Controllers;

use App\Image ;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Redirector;
use App\Game;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display a listing of the resource
     * @return Response
     */
    public function index()
    {
        $images = Image::all();
        return view('pages.upload', compact('images'));
    }

    /**
     * Store a newly created resource in storage
     * @return Response
     */

    public function store()
    {
        $path = 'img/models';
        if(is_dir($path))
        {
            //return redirect()->back()->with('success', 'Images directory ' . $path . ' not found.');
            $handle = opendir($path);
            while(($file = readdir($handle)) !== false)
            {
                if($file != '.' && $file != '..' && $file != '.DS_Store')
                {
                    $extension = pathinfo($file, PATHINFO_EXTENSION);
                    $options = ['jpg', 'png', 'JPG', 'PNG'];

                    if (in_array($extension, $options))
                    {
                        $title = str_slug(basename($file, ".".$extension));
                        $filename = $file;

                        $image = Image::where('filename', '=', $filename)->get();
                        if (count($image) == 0)
                        {
                            Image::create([
                               'title' => $title,
                                'filename' => $filename
                            ]);
                        }
                        else
                        {
                            //return redirect()->back()->with('error', $image->first()->filename . 'Already exists in the database');
                            continue;
                        }

                    }
                }
            }
            closedir($handle);
            return redirect()->back()->with('success', 'All images were succesfully loaded');
        }
        else
        {
            return redirect()->back()->with('error', 'Images directory ' . $path . ' not found.');
        }
    }
}
