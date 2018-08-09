@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="pb-2 mt-4 mb-2 border-bottom">
                <h1>{{ $profileUser->name }}</h1>
            </div>
            <br>
            @foreach($activities as $date => $activity)
            <h3 class="page-header">{{ $date }}</h3>
                @foreach ($activity as $record)
                    @include("profiles.activities.$record->type", ['activity' => $record])
                @endforeach
            @endforeach
        </div>
    </div>
</div>
@endsection