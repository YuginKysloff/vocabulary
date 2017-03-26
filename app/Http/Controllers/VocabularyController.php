<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Word;
use App\Algorithm;
use App\Hash;
use Illuminate\Support\Facades\Auth;

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
        // Get word list with pagination
        $data['vocabulary'] = Word::paginate(10);

        // Get algorithm list
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
        // Check for results
        if(is_array($request->selection))
        {
            // Init result counter
            $count = 1;
            foreach($request->selection as $key => $item)
            {
                // Get word and algorithm by id
                $word = Word::findOrFail($key)->word;
                $alg = Algorithm::findOrFail($item)->name;

                // Organise result array
                $data['result'][$count]['word']['id'] = $key;
                $data['result'][$count]['word']['word'] = $word;
                $data['result'][$count]['algorithm']['id'] = $item;
                $data['result'][$count]['algorithm']['name'] = $alg;
                $data['result'][$count]['hash'] = hash($alg, $word);
                $count++;
            }
        } else {
            $data['result'] = 'No results';
        }

        return view('hash', $data);
    }

    /**
     * Save hash of selected word.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveHash($word_id, $algorithm_id, $hash)
    {
        Hash::create([
            'user_id' => Auth::user()->id,
            'word_id' => $word_id,
            'algorithm_id' => $algorithm_id,
            'hash' => $hash
        ]);

        echo 'Hash saved';
//        return redirect()->back()->with(['message' => 'Hash saved']);
    }
}