@section('title', env('SITE_NAME') . ' | Not Found')
@extends('layout.master')
@section('content')
    <section class="m-t-l p-l fade-in">
        <div class="container">
            <div class="m-t-l has-text-centered">
                <h1 class="title is-1">Page not found</h1>
                <p class="subtitle">The page you are looking for could not be found.</p>
            </div>
        </div>
    </section>
@stop
