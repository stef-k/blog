@if(count($tags) > 0)
    <h2 class="title is-3 has-text-centered m-t-s">Popular Tags</h2>
    @foreach($tags as $tag)
        <a href="{{route('tag', [ 'name' => $tag->name ])}}" class="tag-link">
            <span class="tag is-primary m-t"
                  @if($tag->tag_count > 1)
                  title="{{$tag->tag_count}} entries"
                  @else
                  title="{{$tag->tag_count}} entry"
                    @endif>
                @if($tag->name === 'is-project')
                    project
                @else
                    {{$tag->name}}
                @endif
                {{$tag->tag_count}}

            </span>
        </a>
    @endforeach
    <p class="m-t-s has-text-centered"><a href="{{route('tags')}}">all tags</a></p>
@endif
