@extends('layout.master')
@section('title', 'Projects')
@section('content')
    <div class="m-t-l m-b-m"></div>
    <main class="fade-in">
        <div class="container">
            <h1 class="title is-2 has-text-centered">Some of my projects</h1>

            <div class="columns is-multiline">

                @if(count($posts) > 0)
                    @foreach($posts as $post)
                        <div class="column is-full-mobile is-half-tablet is-4-desktop">
                            <div class="project">
                                <a href="{{ $post->permalink('projects/') }}" title="click to view project details">
                                    <div class="card">
                                        <header class="card-header">
                                            {{--the title--}}
                                            <p class="card-header-title">
                                                {{$post->title}}
                                            </p>
                                        </header>

                                        {{--project image--}}
                                        <div class="card-image item">
                                            @if($post->image(true) != '')
                                                <figure class="image">
                                                    {!! Markdown::parse($post->image(), ['purifier' => false]) !!}
                                                </figure>
                                            @endif
                                        </div>

                                        {{--tags--}}
                                        <div class="card-content">
                                            <div class="content">
                                                @if($post->image(true) == '')
                                                    {!! Markdown::parse($post->excerpt(150, false), ['purifier' => false]) !!}
                                                @endif
                                                @foreach($post->tags as $tag)
                                                    @if($loop->count == 1 && $tag->name == 'is-project')
                                                        {{--keep same height by cheating with whitespace and preformatted text--}}
                                                        <pre> </pre>
                                                    @endif
                                                    @if($tag->name != 'is-project')
                                                        <span class="tag is-primary">{{$tag->name}}</span>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>

                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="has-text-centered centered">There are no projects to show.</p>
                @endif
            </div>
            {{ $posts->links('vendor.pagination.default') }}
        </div>
    </main>
@stop
