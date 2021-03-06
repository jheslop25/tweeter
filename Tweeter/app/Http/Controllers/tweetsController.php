<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class tweetsController extends Controller
{
    public function showAllFollowed(){
        //shows all followed user's tweets
        if(Auth::check()){
            $followed = \App\Follows::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
            $tweets = [];
            $allComments = [];
            if(sizeOf($followed)>0){
                foreach($followed as $follow){
                    $id = $follow->followed_id;
                    //var_dump($id);
                    $getTweets = \App\Tweets::where('user_id', $id)->orderBy('created_at', 'desc')->get();

                    //var_dump($tweets);
                foreach($getTweets as $tweet){
                    // var_dump($tweet->user_id);
                    // var_dump($tweet->content);
                    array_push($tweets, $tweet);
                    $id = $tweet->id;
                    $comments = \App\Comments::where('tweet_id', $id)->get();
                    array_push($allComments, $comments);
                }
            }


                return view('tweetfeed', ['tweets' => $tweets, 'comments' => [$allComments]]);
            } else {
                return redirect('/users');
            }

        }
        return redirect('/login');
    }

    public function createTweet(Request $request){
        //verifies input, Auth, and passes tweet to model
        if(Auth::check()){
            if($request->validate([
                'content' => 'required | min:3 | max:144'
            ])){
                $tweet = new \App\Tweets;
            $tweet->user_id = Auth::user()->id;
            $tweet->content = $request->content;
            $tweet->save();

            if($request->file()){
                $getTweet = \App\Tweets::where('user_id', Auth::user()->id)->where('content', $request->content)->get();
                $photoName = $getTweet[0]->id . 't_id' . $getTweet[0]->user_id . 'tweet_photo';
                var_dump($photoName);
                $request->file('myPhoto')->storeAs('/public/photos', $photoName);
                $path = '/storage/photos/'. $photoName;
                $getTweet[0]->tweet_photo = $path;
                $getTweet[0]->save();
            }

            return back();
            }
        }
    }

    public function returnEdit(Request $request, $user_id){
        if(Auth::user()->id == $user_id){
            $id = $request->edit;
            //var_dump($id);
            $tweets = \App\Tweets::find($id);
            //var_dump($tweets);
            $comments = \App\Comments::where('tweet_id', $id)->get();

            return view('editTweet', ['tweets' => [$tweets], 'comments' => $comments]);

        } else {
            return redirect('/tweets');
        }
    }

    public function updateTweet(Request $request){
        //verifies input, Auth, and passes values to model
        if(Auth::user()->id == $request->user_id){
            if($request->validate([
                'content' => 'required | min:3 | max:144'
            ])){
            $id = $request->tweet_id;
            var_dump($id);
            $tweet = \App\Tweets::find($id);

            var_dump($tweet);
            $tweet->content = $request->content;

            $tweet->save();

            return back();
            }
        }
    }

    public function destroyTweet(Request $request){
        //verifies input, Auth, and passes instructions to model
        $id = $request->id;
        if(Auth::user()->id == \App\Tweets::find($id)->user_id){
            \App\Tweets::destroy($id);
            return back();
        }

    }

    public function viewTweet($id){
        // returns a view with a single tweet
        $tweets = \App\Tweets::find($id);
        $comments = \App\Comments::where('tweet_id', $id)->get();
        //var_dump($comments);
        if(sizeof($comments) >0){
            $userId = $comments[0]->user_id;
            $user = \App\User::find($userId);
            //var_dump($user);
            return view('editTweet', ['tweets' => [$tweets], 'comments' => $comments, 'user' => $user]);
        } else {
            return view('editTweet', ['tweets' => [$tweets], 'comments' => $comments]);
        }

    }

    public function retweet(Request $request){
        if(Auth::check()){
            $retweet = new \App\Tweets;
            $retweet->user_id = Auth::user()->id;
            $retweet->content = $request->content;
            $retweet->orig_tweeter_name = $request->name;
            $retweet->orig_created_at = $request->created_at;
            $retweet->tweet_photo = $request->tweet_photo;

            $retweet->save();

            return back();
        }
    }
}
