@extends('layouts/app')
@section('content')
    <div class="container">
        @include('flash::message')
        <div class="pb-5">
        <a href="{{url('/timeline/')}}" class="btn btn-primary">
            Switch to timeline
        </a>
        </div>
        @foreach($tweets as $tweet)
            <div class="row">
                <div class="pb-4">
                {{ $tweet->user->name }} : {{ $tweet->text }}
                <a href="{{url('/delete/tweet/'.$tweet->id)}}" class="btn btn-primary">
                    Delete
                </a>
                </div>
            </div>
        @endforeach
        {{ $tweets->links() }}

    </div>
@endsection
