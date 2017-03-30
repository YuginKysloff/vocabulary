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
        if(is_array($request->selection) && $request->algorithm)
        {
            $data['result']['string'] = '';
            foreach($request->selection as $item) $data['result']['string'] .= $item;

            $data['result']['algorithm']['code'] = $request->algorithm;
            $data['result']['algorithm']['name'] = Algorithm::findOrFail($request->algorithm)->name;
            $data['result']['hash'] = hash($data['result']['algorithm']['name'], $data['result']['string']);

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
    public function saveHash(Request $request, $string, $algorithm, $hash)
    {
        // Save favorite word to DB
        Hash::create([
            'user_id' => auth()->user()->id,
            'string' => $string,
            'algorithm' => $algorithm,
            'hash' => $hash
        ]);

        //Save to DB user's information
        DB::table('users')->
            where('id', auth()->user()->id)->
            update([
                'ip' => $request->ip(),
                'user_agent' => $request->server('HTTP_USER_AGENT'),
                'country' => $this->getCountryCodeFromIp($request->ip())
            ]);

        return redirect()->route('account');
    }

    /**
     * Get current user's stored words.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAccount(Request $request)
    {
        $hashes = Hash::select('string', 'algorithm', 'hash')->where('user_id', auth()->user()->id)->get();

        $data['result']['hashes'] = (count($hashes) > 0) ? response()->json($hashes) : 'No results';
        $data['result']['country'] = DB::table('ip2nationCountries')->
                                        select('country')->
                                        where('code', $this->getCountryCodeFromIp($request->ip()))->
                                        first();
        $data['result']['request'] = $request;

//        $data['result']['userAgent'] = get_browser(null, true);

        return view('account', $data);
    }
}