<?php

namespace App\Http\Controllers;

use App\Tweet;
use Illuminate\Http\Request;
use App\Http\Requests\ContactFormRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Thujohn\Twitter\Facades\Twitter;

class TwitterController extends Controller
{
    public function viewTweets()
    {
        $timeline = Twitter::getHomeTimeline();
        $paginator = $this->paginate($timeline, 5);
        return view('twitter.timeline',[
            'tweets' => $paginator
        ]);
    }

    public function myTweets()
    {
        $timeline = Twitter::getUserTimeline();
        $paginator = $this->paginate($timeline, 5);
        return view('twitter.my_timeline',[
            'tweets' => $paginator
        ]);
    }

    public function createTweet()
    {
        return view('twitter.create');
    }

    public function sendTweet(Request $request)
    {
        $tweet = $request->get('tweet');

        $tweet = Twitter::postTweet(array('status' => $tweet, 'format' => 'json'));
        $twitter = new Tweet();
        $twitter->tweet_id = json_decode($tweet)->id;
        $twitter->save();
        flash('Your tweet has been sent!');

        return redirect()->route('twitter.createTweet');

    }

    public function deleteTweet($id)
    {
        Twitter::destroyTweet($id);
        return redirect()->route('twitter.timeline');
    }

    function paginate($items, $perPage)
    {
        $pageStart           = request('page', 1);
        $offSet              = ($pageStart * $perPage) - $perPage;
        $itemsForCurrentPage = array_slice($items, $offSet, $perPage, TRUE);

        return new LengthAwarePaginator(
            $itemsForCurrentPage, count($items), $perPage,
            Paginator::resolveCurrentPage(),
            ['path' => Paginator::resolveCurrentPath()]
        );
    }
}
