@section('og')
    <meta property="og:title" content="{{$post->title}}">
    <meta property="og:type" content="article">
    <meta property="og:locale" content="en_US">
    <meta property="og:url" content="{{ url('/') . $post->permalink()}}">
    @if($post->image(true) != '')
        <meta property="og:image" content="{{ url('/') . $post->image(true) }}">
    @else
        <meta property="og:image" content="{{ url('/') . 'icon.png' }}">
    @endif
    <meta property="og:image:width" content="128">
    <meta property="og:image:height" content="128">
    <meta property="og:image:type" content="image/png">
    <meta property="article:published_time" content="{{$post->published_at}}">
    <meta property="og:description" content="{{$post->excerpt(200, false)}}">
@stop

@section('title', $post->title )
@extends('layout.master')

@section('content')
    <div class="m-l"></div>
    <article class="fade-in">
        <div class="container">
            <div class="columns">
                <div class="column is-full-mobile is-8 is-offset-2">
                    <a href="{{ route('projects') }}" title="back to projects index">back to projects</a>
                </div>
            </div>

            <div class="columns">
                @include('layout.social')
                <div class="column is-11-mobile is-offset-1-mobile is-8 is-offset-2">
                    <article class="entry" itemscope itemType="http://schema.org/BlogPosting">
                        <h1 class="title is-1 has-text-centered post-title" itemprop="headline">{{ $post->title }}</h1>
                        <div class="font-normal light-notice m-t-s">
                            <span itemprop="datePublished">published at: {{date('M, d Y', strtotime($post->published_at))}}</span>
                            <span class="is-pulled-right" itemprop="dateModified">updated at: {{ date('M, d Y', strtotime($post->updated_at))  }}</span>
                            <div class="m-t-s">
                                @foreach($post->tags as $tag)
                                    @if(!$tag->name == 'is-project' || !$tag->name == 'isproject')
                                        <span class="tag is-primary m-t">{{$tag->name}}</span>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="post" itemprop="articleBody">
                            {!! Markdown::parse($post->body, ['purifier' => false]) !!}
                        </div>

                        {{--Structured data attributes--}}
                        <div class="light-notice font-normal">
                            <span itemprop="author" hidden>by {{$author}}</span>
                        </div>
                        @if($post->image(true) != '')
                            <link itemprop="image" href="{{$post->image(true)}}" hidden/>
                        @else
                            <link itemprop="image" href="{{env('APP_URL') . elixir('img/icon.png')}}" hidden/>
                        @endif

                        <div itemprop="publisher" itemscope itemtype="https://schema.org/Organization" hidden>
                            <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
                                <img src="{{elixir('img/icon.png')}}" alt="publisher icon">
                                <meta itemprop="url" content="{{env('APP_URL') . elixir('img/icon.png')}}">
                                <meta itemprop="width" content="128">
                                <meta itemprop="height" content="128">
                            </div>
                            <meta itemprop="name" content="{{env('SITE_NAME')}}">
                        </div>
                    </article>
                </div>
            </div>

            <div class="columns">
                <div class="column is-full-mobile is-8 is-offset-2">
                    <a href="{{ route('projects') }}" title="back to projects index">back to projects</a>
                </div>
            </div>
        </div>
    </article>
@stop
