@section('title', env('SITE_NAME') . ' | Server Error')
@extends('layout.master')
@section('content')
    <section class="m-t-l p-l fade-in">
        <div class="container">
            <div class="m-t-l has-text-centered">
                <h1 class="title is-1">Server Error</h1>
                <p class="subtitle">Something broke, fortunately it is written in log files for further investigation.</p>
            </div>
        </div>
    </section>
@stop
