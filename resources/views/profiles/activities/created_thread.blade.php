@component('profiles.activities.activity')
    @slot('heading')
        {{ $profileUser->name }} replied to 
        <a href="{{ $activity->subject->path() }}">"{{ $activity->subject->title }}"</a> 
    @endslot
    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent

{{-- @include('profiles.activities.activity', [
    'heading' => 'my heading',
    'body'    => 'my body'
]) --}}