<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Word;
use App\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['vocabulary'] = Word::paginate(10);

        $data['hashes'] = Hash::all();

        return view('home', $data);
    }
}
