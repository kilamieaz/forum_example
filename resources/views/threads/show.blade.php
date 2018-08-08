@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="level">
                        <span class="flex">
                            <a href="{{ route('profile', $thread->creator) }}">
                                {{ $thread->creator->name }}    
                            </a>posted: {{ $thread->title }}
                        </span>
                        <form action="{{ $thread->path() }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link">Delete Thread</button>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    {{ $thread->body }}
                </div>
            </div>

            @foreach ($replies as $reply)
                @include('threads.reply')
            @endforeach
            {{ $replies->links() }}

            @if (auth()->check())
            <form method="POST" action="{{ $thread->path() . '/replies'}}">
                @csrf
                <div class="form-group">
                    <textarea class="form-control" id="body" name="body" placeholder="Have something to say?" rows="5"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Post</button>
            </form> 
            @else
            <p class="text-center">Please <a href="{{ route('login') }}">Sign in</a>to participate in this discussion.</p>
            @endif
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    This thread was published {{  $thread->created_at->diffForHumans()}} by 
                    <a href="#">{{ $thread->creator->name }}</a>, and currently has {{ $thread->replies_count }} 
                    {{ str_plural('comment', $thread->replies_count) }}.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
