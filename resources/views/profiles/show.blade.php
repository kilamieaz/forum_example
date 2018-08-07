@extends('layouts.app')

@section('content')
<div class="container">
    <div class="pb-2 mt-4 mb-2 border-bottom">
        <h1>{{ $profileUser->name }}</h1>
        <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
    </div>
    <br>
    @foreach($threads as $thread)
    <div class="card">
        <div class="card-header">
            <div class="level">
                <span class="flex">
                    <a href="#">
                        {{ $thread->creator->name }}    
                    </a>posted: {{ $thread->title }}
                </span>
                <span>{{ $thread->created_at->diffForHumans() }}</span>
            </div>
        </div>

        <div class="card-body">
            {{ $thread->body }}
        </div>
    </div>
    <hr>
    @endforeach
    {{ $threads->links() }}
</div>
@endsection