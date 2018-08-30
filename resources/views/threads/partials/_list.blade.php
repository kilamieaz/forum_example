@forelse ($threads as $thread)
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">Forum Threads</div>

            <div class="card-body">
                <article>
                    <div class="level">
                        <div class="flex">
                            <h4>
                                <a href="{{ $thread->path() }}">
                                    @if (auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                                        <b>
                                            {{ $thread->title }}
                                        </b>
                                    @else
                                        {{ $thread->title }}
                                    @endif
                                </a>
                            </h4>
                            <h5>
                                Posted By: <a href="{{ Route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a>
                            </h5>
                        </div>
                    <a href="{{ $thread->path() }}">{{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}</a>
                    </div>
                    <div class="body">{{ $thread->body  }}</div>
                </article>
            </div>
        </div>
    </div>
@empty
    <p>There are no relavant results at this time.</p>
@endforelse