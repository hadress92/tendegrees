@extends('layouts/app')
@section('content')
<div class="container">
    @include('flash::message')
</div>
{!! Form::open(['route' => 'twitter.sendTweet']) !!}

<div class="form-group">
    {!! Form::label('tweet', 'New Tweet') !!}
    {!! Form::textArea('tweet', null, ['class' => 'form-control']) !!}
</div>

{!! Form::submit('Submit', ['class' => 'btn btn-info']) !!}

{!! Form::close() !!}

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@endsection