@extends('layouts/app')
@section('content')
<div class="container">
    @include('flash::message')
    <div class="pb-5">
    <a href="{{url('/my/timeline')}}" class="btn btn-primary">
        Switch to my tweets
    </a>
    </div>
    @foreach($tweets as $tweet)
        <div class="row">
            <div class="pb-4">
            {{ $tweet->user->name }} : {{ $tweet->text }}
            </div>
        </div>
    @endforeach
    {{ $tweets->links() }}
    </div>
@endsection
