@extends('layouts.app')
@push('head')
    <link rel="stylesheet" href="/css/vendor/jquery.atwho.css">
@endpush
@section('content')
<thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="level">
                        <img src="{{ Storage::url($thread->creator->avatar()) }}" alt="{{ $thread->creator->name }}" width="25" height="25" class="mr-2">
                        <span class="flex">
                            <a href="{{ route('profile', $thread->creator) }}">
                                {{ $thread->creator->name }}    
                            </a>posted: {{ $thread->title }}
                        </span>
                        @can('update', $thread)
                        <form action="{{ $thread->path() }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link">Delete Thread</button>
                        </form>
                        @endcan
                    </div>
                </div>

                <div class="card-body">
                    {{ $thread->body }}
                </div>
            </div>
            <replies @added="repliesCount++" @removed="repliesCount--"></replies>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p>
                        This thread was published {{  $thread->created_at->diffForHumans()}} by 
                        <a href="#">{{ $thread->creator->name }}</a>
                        , and currently has <span v-text="repliesCount"></span> 
                        {{ str_plural('comment', $thread->replies_count) }}.
                    </p>
                    @if (Auth::check())
                        <p>
                            <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}"></subscribe-button>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</thread-view>
@endsection
