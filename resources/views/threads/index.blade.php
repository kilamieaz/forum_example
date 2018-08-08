@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @foreach ($threads as $thread)
            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-header">Forum Threads</div>

                    <div class="card-body">
                        <article>
                            <div class="level">
                                <h4 class="flex">
                                    <a href="{{ $thread->path() }}">
                                        {{ $thread->title }}
                                    </a>
                                </h4>
                            <a href="{{ $thread->path() }}">{{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}</a>
                            </div>
                            <div class="body">{{ $thread->body  }}</div>
                        </article>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
