@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('threads.partials._list')
    </div>
</div>
@endsection
