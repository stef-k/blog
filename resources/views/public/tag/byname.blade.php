@extends('layout.master')
@section('title', 'Posts')
@section('content')
    <div class="m-l"></div>
    <main class="fade-in">
        <div class="container">
            <div class="columns">
                <div class="column is-full-mobile is-8-desktop is-offset-1-desktop">
                    <h1 class="title is-2 has-text-centered">Posts</h1>
                </div>
            </div>

            <div class="columns is-gapless">
                <div class="column">
                    @if(count($posts) > 0)
                        @foreach($posts as $post)
                            <div class="columns ">
                                <div class="column is-full-mobile is-8-desktop is-offset-2-desktop">
                                    <article class="post-index">

                                        @if($post->tags->contains('name', 'is-project'))
                                            <a href="{{ $post->permalink('projects/') }}">
                                                @else
                                                    <a href="{{ $post->permalink() }}">
                                                        @endif

                                                        <h2 class="title is-3 has-text-centered post-title">
                                                            {{$post->title}}
                                                        </h2>

                                                        <p class="m-y-s font-normal light-notice">
                                            <span>
                                                Published at {{date('M, d Y', strtotime($post->published_at))}}
                                            </span>
                                                            <span class="is-pulled-right">
                                                @foreach($post->tags as $tag)
                                                                    <span class="tag is-primary m-t">{{$tag->name}}</span>
                                                                @endforeach
                                            </span>
                                                        </p>

                                                        <div class="post-excerpt post">
                                                            {{--featured image if exists...--}}
                                                            @if($post->image(true) != '')
                                                                {!! Markdown::parse($post->image(), ['purifier' => false]) !!}
                                                            @endif
                                                            {!! Markdown::parse($post->excerpt(150, false), ['purifier' => false]) !!}
                                                        </div>
                                                    </a>
                                                    <hr>
                                    </article>

                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="has-text-centered">There are no posts to show.</p>
                    @endif
                    <div class="is-hidden-mobile">
                        {{ $posts->links('vendor.pagination.default') }}
                    </div>
                </div>

                <div class="column is-2-desktop is-centered">
                    @include('public.common.search')
                    @include('public.tag.popular')
                </div>

            </div>

            <div class="is-hidden-tablet">
                {{ $posts->links('vendor.pagination.default') }}
            </div>

        </div>
    </main>
@stop
