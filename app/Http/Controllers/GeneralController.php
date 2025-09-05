<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function about()
    {
        return view('about');
    }

    public function howItWorks()
    {
        return view('how-it-works');
    }

    public function testimonies()
    {
        return view('testimonies');
    }

    public function contact()
    {
        return view('contact');
    }

}
