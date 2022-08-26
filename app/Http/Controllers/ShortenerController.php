<?php

namespace App\Http\Controllers;

use App\Models\ShortenerUrl;
use Illuminate\Http\Request;

class ShortenerController extends Controller
{
    const CHARS = "abcdfghjkmnpqrstvwxyz|ABCDFGHJKLMNPQRSTVWXYZ|0123456789";

    protected $rules = [
        'url' => 'required|url',
        'custom_alias' => 'nullable|unique:shortener_urls,alias',
    ];

    protected $messages = [
        'url.required' => 'The URL field is required.',
        'url.url' => 'The URL field must be a valid URL.',
        'custom_alias.unique' => 'This custom alias already exists.',
    ];

    public function getMoreAccessed()
    {
        $urls = ShortenerUrl::orderBy('clicks', 'desc')->take(10)->get();

        return response()->json($urls);
    }

    public function store()
    {
        request()->validate($this->rules, $this->messages);

        $startTime = hrtime(true);

        $url = request()->url;

        if (request()->has('custom_alias')) {
            $alias = $this->shorten(request()->custom_alias);
        } else {
            $alias = $this->shorten();
        }

        $endTime = hrtime(true);

        ShortenerUrl::create([
            'url' => $url,
            'alias' => $alias,
        ]);

        $timeTakenInMs = $this->microtimeFormat($endTime - $startTime);

        return response()->json([
            'alias' => $alias,
            'url' => 'example.com/' . $alias,
            'statistics' => [
                'time_taken' => $timeTakenInMs . 'ms',
            ]
        ]);
    }

    public function storeClient()
    {
        request()->validate($this->rules, $this->messages);

        $url = request()->url;

        if (request()->has('custom_alias')) {
            $alias = $this->shorten(request()->custom_alias);
        } else {
            $alias = $this->shorten();
        }

        ShortenerUrl::create([
            'url' => $url,
            'alias' => $alias,
        ]);

        session()->flash('shortener_url', 'example.com/' . $alias);

        return redirect()->route('home');
    }

    private function shorten($customAlias = null)
    {
        $shortUrl = $customAlias ? $customAlias : $this->generateRandomString();
        return $shortUrl;
    }

    private function generateRandomString($length = 6){
        $sets = explode('|', self::CHARS);
        $all = '';
        $randString = '';
        foreach($sets as $set){
            $randString .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
        $all = str_split($all);
        for($i = 0; $i < $length - count($sets); $i++){
            $randString .= $all[array_rand($all)];
        }
        $randString = str_shuffle($randString);
        return $randString;
    }

    private function microtimeFormat($duration)
    {
        $miliseconds = $duration % 1000;
        return number_format($miliseconds, 0, '.', '');
    }
}
