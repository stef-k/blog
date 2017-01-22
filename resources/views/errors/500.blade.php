@section('title', env('SITE_NAME') . ' | Service Unavailable')
@extends('layout.master')
@section('content')
    <section class="m-t-l p-l fade-in">
        <div class="container">
            <div class="m-t-l has-text-centered">
                <h1 class="title is-1">Service Unavailable</h1>
                <p class="subtitle">Doing maintenance work, will be right back.</p>
            </div>
        </div>
    </section>
@stop
