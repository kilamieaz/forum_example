@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <a href="#">
                        {{ $thread->creator->name }}    
                    </a>posted: {{ $thread->title }}
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{ $thread->body }}
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8 mb-4">
            @foreach ($thread->replies as $reply)
                @include('threads.reply')
            @endforeach
        </div>
    </div>

    @if (auth()->check())
        <div class="row justify-content-center">
            <div class="col-md-8 mb-4">
                <form method="POST" action="{{ $thread->path() . '/replies'}}">
                    <div class="form-group">
                      <textarea class="form-control" id="body" name="body" placeholder="Have something to say?" rows="5"></textarea>
                        <button type="submit" class="btn btn-primary">Post</button>
                    </div>      
                </form> 
            </div>
        </div>
    @else
    <p class="text-center">Please <a href="{{ route('login') }}">Sign in</a>to participate in this discussion.</p>
    @endif
</div>
@endsection
