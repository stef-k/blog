@extends('layout.master')
@section('title', 'All tags')
@section('content')
    <div class="m-l"></div>
    <main class="fade-in">
        <div class="container">
            <h1 class="title is-2 has-text-centered">All Tags</h1>
            <p class="has-text-centered subtitle">
                All tags by post count, click on a tag to go to related posts.
            </p>

            <div class="columns">
                <div class="column is-12-mobile is-8-desktop is-offset-2-desktop">
                    @if(count($tags) > 0)
                        @foreach($tags as $tag)
                            <a href="{{route('tag', [ 'name' => $tag->name ])}}"
                               @if($tag->tag_count > 1)
                               title="{{$tag->tag_count}} related posts"
                               @else
                               title="{{$tag->tag_count}} related post"
                                    @endif
                            >
                            <span class="tag is-medium is-primary m-t">@php echo mb_strtoupper($tag->name) @endphp
                                : {{$tag->tag_count}}
                            </span>
                            </a>
                        @endforeach
                    @else
                    <p class="has-text-centered">
                        There are no tags to show.
                    </p>
                    @endif
                </div>
            </div>
        </div>
    </main>
@stop
