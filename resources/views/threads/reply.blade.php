<reply :attributes="{{ $reply }}" inline-template>
    <div id="reply-{{ $reply->id }}" class="card my-4">
        <div class="card-header">
            <div class="level">
                <h5 class="flex">
                    <a href="{{ route('profile', $reply->owner) }}">
                        {{ $reply->owner->name }}
                    </a> said  {{ $reply->created_at->diffForHumans() }}...
                </h5>
                <div>
                    <form method="POST" action="/replies/{{ $reply->id }}/favorites">
                        @csrf
                        <button type="submit" class="btn btn-default" {{ $reply->isFavorited() ? 'disabled' : ''}}>
                            {{ $reply->favorites_count }} {{ str_plural('Favorite', $reply->favorites_count) }}
                        </button>  
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div v-if="editing">
                <textarea class="form-control" v-model="body"></textarea>
            </div>
            <div v-else>
                {{ $reply->body }}
            </div>
        </div>
        @can('update', $reply)
            <div class="card-footer level">
                <button type="button" class="btn btn-xs mr-1" @click="editing = true">Edit</button>
                <form action="/replies/{{ $reply->id }}">
                    @csrf
                    @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        @endcan
    </div>
</reply>