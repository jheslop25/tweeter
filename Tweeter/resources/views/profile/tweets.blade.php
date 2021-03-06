
@foreach ($tweets as $tweet)
<div class="col-md-10 card my-3 mx-3 p-3">
    <div class="card-body">
        <h4 class="card-title text-muted">@ {{$user[0]->name}} <img class="img-fluid" style="width: 30px;" src="{{ url('/logo.png')}}" alt="The Great Ironic Eagle"></h4>
        @if ($tweet->orig_tweeter_name)
            <p>Retweet from @ {{$tweet->orig_tweeter_name}}<img class="img-fluid" style="width: 30px;" src="{{ url('/logo.png')}}" alt="The Great Ironic Eagle"></p>
        @endif
        @if($tweet->tweet_photo)
            <img class="img-fluid" style="width:200px" src="{{$tweet->tweet_photo}}" alt="dank memes">
        @endif
        <h5 class="card-text">{{$tweet->content}}</h5>
    </div>
    <div class="btn-group ml-3 mb-2" role="group">
        @if (Auth::user()->id == $tweet->user_id)
            <form action="/tweets/goToEdit/{{$tweet->user_id}}" method="get">
                @csrf
                <button class="btn btn-secondary m-1" type="submit" name="edit" value="{{$tweet->id}}">Edit</button>
            </form>
            <form action="/tweets/destroy/" method="post">
                @csrf
                <button class="btn btn-secondary m-1" type="submit" name="id" value="{{$tweet->id}}" onclick="Are you sure?">Delete</button>
            </form>
        @endif
        <form action="/tweets/view/{{$tweet->id}}" method="get">
            @csrf
            <button class="btn btn-primary m-1" type="submit" name="id">View</button>
        </form>
    </div>
    <div class="container">
        <p>Comments:</p>
        @foreach ($comments[0] as $comment)

                    @foreach ($comment as $content)

                        @if($content->tweet_id == $tweet->id)
                        <div class="card mb-3 p-3">
                        <a href="/user/{{$content->user_id}}">@ {{getUserName($content->user_id)}}<img class="img-fluid" style="width: 30px;" src="{{ url('/logo.png')}}" alt="The Great Ironic Eagle"></a>
                        <p>{{$content->content}}</p>
                        </div>
                        @endif

                    @endforeach
        @endforeach
        <a href="/tweets">Back to Tweet Feed</a>
    </div>
</div>
@endforeach

