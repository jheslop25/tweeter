@extends('layouts.app')

@include('functions')
@section('content')
@include('create')
@foreach ($tweets as $tweet)
<div class="card m-4 p-3">
<h5>user id: {{$tweet->user_id}}</h5>
<h6>Content: {{$tweet->content}}</h6>
<p>tweet id: {{$tweet->id}}</p>

{{-- @php
    var_dump($tweet);
@endphp --}}
@if (Auth::user()->id == $tweet->user_id)
    <form action="/tweets/goToEdit/{{$tweet->user_id}}" method="get">
        @csrf
        <button class="btn btn-dark m-2" type="submit" name="edit" value="{{$tweet->id}}">Edit</button>
    </form>
    <form action="/tweets/destroy/" method="post">
        @csrf
        <button class="btn btn-dark m-2" type="submit" name="id" value="{{$tweet->id}}" onclick="Are you sure?">Delete</button>
    </form>
@endif
<form action="/tweets/view/{{$tweet->id}}" method="get">
    @csrf
    <button class="btn btn-primary m-2" type="submit" name="id">View</button>
</form>
@include('likes')
{{-- @include('comments.show')
@include('comments.create') --}}
</div>
@endforeach
@endsection
