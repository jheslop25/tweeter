<form class="card p-3" action="/tweets/comment/create" method="post">
    @csrf
    <input class="form-control" type="text" name="comment" value="make a comment">
<input type="number" name="tweetId" value="{{$tweet->id}}" readonly class="d-none">
    <button class="btn btn-primary mt-2" type="submit">Comment</button>
    {{-- will add edit/ delete buttons here later --}}
</form>