@section('og')
    <meta property="og:title" content="icCode - Stef K">
    <meta property="og:site_name" content="icCode">
    <meta property="og:locale" content="en_US">
    <link rel="canonical" href="{{url('/')}}">
    <meta property="og:url" content="{{url('/')}}">
    <meta property="og:description" content="Personal site of Stef K">

    <meta property="og:image" content="{{url('/') . 'icon.png' }}">
    <meta property="og:image:width" content="64">
    <meta property="og:image:height" content="64">
    <meta property="og:image:type" content="image/png">
@stop
@section('title', env('SITE_NAME') . ' | ' . env('USERNAME'))
@extends('layout.master')
@section('content')
    <main role="main" class="fade-in">
        <div class="columns is-fullheight ">
            <div class="column left-side is is-half-desktop is-hidden-touch">
                <section class="hero is-fullheight is-default is-bold">
                    <div class="hero-body">
                        <div class="container has-text-centered">
                            <h1 class="title is-1">icCode</h1>
                            <h2 class="subtitle is-4">Welcome</h2>
                        </div>
                    </div>
                </section>
            </div>
            <div class="column right-side is-half-desktop is-full-mobile v-centered m-t-l">
                <div class="container">
                    <div class="box">
                        <div class="columns">
                            <div class="column is-4">
                                <figure class="image ">
                                    <img src="{{ asset('img/me.jpg')  }}" alt="Me" class="is-rounded anime anime-1">
                                </figure>
                                <div class="content p-t-s">
                                    <h3 class="title is-4 has-text-centered">Technologies currently working or have
                                        worked with in the past</h3>
                                    <p>
                                        <span class="tag is-primary m-t">PHP</span>
                                        <span class="tag is-primary m-t">Laravel</span>
                                        <span class="tag is-primary m-t">WordPress</span>
                                        <span class="tag is-primary m-t">Go</span>
                                        <span class="tag is-primary m-t">Beego</span>
                                        <span class="tag is-primary m-t">Python</span>
                                        <span class="tag is-primary m-t">Django</span>
                                        <span class="tag is-primary m-t">Ionic</span>
                                    </p>
                                </div>
                            </div>
                            <div class="column">

                                <div class="content is-medium is-justified">
                                    <p> Hi, my name is <span class="anime anime-2">Stefanos</span> <span
                                                class="anime anime-3">Kariotidis</span> and this is my personal space on
                                        web. When
                                        not at
                                        work, I
                                        like to write code and watch movies. I am a big Star Wars fun and otaku. I am
                                        also
                                        proud
                                        holder of a BSc (Honours) Open from The Open University UK with focus in
                                        computing,
                                        which I
                                        have earned while working full time in unrelated sector.
                                    </p>
                                    <p>
                                        You can contact me using the <a href="#">contact page</a> or you can also find
                                        me at
                                        <a href="https://imaginebinary.io" target="_blank"
                                           title="check where I currently work">Imagine
                                            Binary</a>
                                        which is the company I currently work for as a freelancer. It is a software
                                        development
                                        company offering web and mobile development services.
                                    </p>

                                    <h3 class="title is-3">About this site</h3>
                                    <p>After using WordPress for years, I've found the time to create something from the
                                        ground
                                        up. The result is this site which is made with <a href="https://laravel.com/"
                                                                                          target="_blank">Laravel</a> .
                                        The public half, is made with blade templates
                                        while the admin half uses <a href="Vue.js" target="_blank">Vue.js</a> v2.
                                    </p>
                                    <p>
                                        If you are interested or you want to use it, you can find the code at
                                        <a href="#" target="_blank">Github</a>
                                    </p>

                                    <p class="has-text-centered text-dark">
                                        I am open for business proposals, looking forward to collaborate with other
                                        people,
                                        to see and learn new things in software development.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('layout.footer')
                </div>

            </div>

        </div>
    </main>

@stop
