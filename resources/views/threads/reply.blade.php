<reply :attributes="{{ $reply }}" inline-template v-clock>
    <div id="reply-{{ $reply->id }}" class="card my-4">
        <div class="card-header">
            <div class="level">
                <h5 class="flex">
                    <a href="{{ route('profile', $reply->owner) }}">
                        {{ $reply->owner->name }}
                    </a> said  {{ $reply->created_at->diffForHumans() }}...
                </h5>
                <div>
                    @if (Auth::check())
                        <favorite :reply="{{ $reply }}"></favorite>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>
                <button type="submit" class="btn btn-xs btn-primary" @click="update">Update</button>
                <button type="submit" class="btn btn-xs btn-link" @click="editing = false">Cancel</button>
            </div>
            <div v-else v-text="body"></div>
        </div>
        @can('update', $reply)
            <div class="card-footer level">
                <button type="button" class="btn btn-xs mr-1" @click="editing = true">Edit</button>
                <button type="button" class="btn btn-danger mr-1" @click="destroy">Delete</button>
            </div>
        @endcan
    </div>
</reply>