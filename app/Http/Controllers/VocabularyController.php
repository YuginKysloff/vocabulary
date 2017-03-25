<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Word;
use App\Algorithm;

class VocabularyController extends Controller
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
     * Show the vocabulary list.
     *
     * @return \Illuminate\Http\Response
     */
    public function getVocabulary()
    {
        $data['vocabulary'] = Word::paginate(10);

        $data['algorithms'] = Algorithm::all();

        return view('vocabulary', $data);
    }

    /**
     * Show hash of selected word.
     *
     * @return \Illuminate\Http\Response
     */
    public function getHash(Request $request)
    {
//        dump($request);

        return view('hash');
    }
}
