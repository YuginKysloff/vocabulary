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
        // Save favorite word to DB
        Hash::create([
            'user_id' => auth()->user()->id,
            'word_id' => $request->word_id,
            'algorithm_id' => $request->algorithm_id,
            'hash' => $request->hash
        ]);

        //Save to DB user's information
        DB::table('users')->
            where('id', auth()->user()->id)->
            update([
                'ip' => $request->ip(),
                'user_agent' => $request->server('HTTP_USER_AGENT'),
                'country' => $this->getCountryCodeFromIp($request->ip())
            ]);

        return response()->json(['word_id' => $request->word_id]);
    }

    /**
     * Get current user's stored words.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAccount(Request $request, $id)
    {
        $hashes = DB::table('hashes')->
                    select('vocabulary.word', 'algorithms.name as algorithm', 'hashes.hash')->
                    join('vocabulary', 'hashes.word_id', '=', 'vocabulary.id')->
                    join('algorithms', 'hashes.algorithm_id', '=', 'algorithms.id')->
                    where('hashes.user_id', $id)->
                    get();

        $data['result']['hashes'] = (count($hashes) > 0) ? response()->json($hashes) : 'No results';
        $data['result']['ip'] = $request->ip();
        $data['result']['userAgent'] = $request->server('HTTP_USER_AGENT');
        $data['result']['country'] = DB::table('ip2nationCountries')->
                                        select('country')->
                                        where('code', $this->getCountryCodeFromIp($request->ip()))->
                                        first();

//        $data['result']['userAgent'] = get_browser(null, true);

        return view('account', $data);
    }

    public function getCountryCodeFromIp($ip)
    {
        $result = DB::table('ip2nationCountries as c')->
                        select('c.code')->
                        join('ip2nation AS i', 'c.code', '=', 'i.country')->
                        where('i.ip', '<', DB::raw('INET_ATON("'.$ip.'")'))->
                        orderBy('i.ip', 'DESC')->
                        first();

        return (is_object($result)) ? $result->code : null;
    }
}