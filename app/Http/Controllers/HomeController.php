<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\models\blog\Blog;
use Session;


class HomeController extends Controller
{
    public function home()
    {
       
        return view('home');
    }
}
