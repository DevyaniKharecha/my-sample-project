<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PagesController extends Controller
{

    public function index()
    {
        return view('pages.index');
    }

    public function terms()
    {

        return view('pages.terms-of-service');
    }

    public function privacy()
    {

        return view('pages.privacy');
    }

}
