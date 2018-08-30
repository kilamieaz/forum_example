@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="pb-2 mt-4 mb-2 border-bottom">
                <h1>{{ $profileUser->name }}</h1>
                @can('update', $profileUser)
                    <form method="POST" action="{{ route('avatar_path', $profileUser->id) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="avatar">
                        <button type="submit" class="btn btn-primary">Add Avatar</button>
                    </form>
                @endcan
                <img src="{{ Storage::url($profileUser->avatar()) }}" width="50" height="50">
            </div>
            <br>
            @forelse($activities as $date => $activity)
                <h3 class="page-header">{{ $date }}</h3>
                @foreach ($activity as $record)
                    @if (view()->exists("profiles.activities.{$record->type}"))
                        @include("profiles.activities.$record->type", ['activity' => $record])
                    @endif  
                @endforeach
            @empty
                <p>There is no activity for this user yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection