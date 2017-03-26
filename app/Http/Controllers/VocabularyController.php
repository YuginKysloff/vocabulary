<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Word;
use App\Algorithm;
use App\Hash;
use Illuminate\Support\Facades\DB;

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
    public function saveHash(Request $request)
    {
        Hash::create([
            'user_id' => auth()->user()->id,
            'word_id' => $request->word_id,
            'algorithm_id' => $request->algorithm_id,
            'hash' => $request->hash
        ]);

        return response()->json(['word_id' => $request->word_id]);
    }

    /**
     * Get current user's stored words.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAccount($id)
    {
//        $data['result'] = Hash::where('user_id', $id)->get();

        $data = DB::table('hashes')->
                    select('vocabulary.word', 'algorithms.name as algorithm', 'hashes.hash')->
                    join('vocabulary', 'hashes.word_id', '=', 'vocabulary.id')->
                    join('algorithms', 'hashes.algorithm_id', '=', 'algorithms.id')->
                    where('hashes.user_id', $id)->
                    get();

        if(count($data) > 0) {
            return view('account', ['result' => response()->json($data)]);
        } else {
            return view('account', ['result' => 'No results']);
        }
    }
}