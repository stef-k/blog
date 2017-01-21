@section('title', 'Contact')
@extends('layout.master')
<section class="m-t-l p-l fade-in">
    <div class="container">
        <div class="columns">
            <div class="column is-half-desktop is-offset-one-quarter">
                @include('layout.feedback')
                <div class="box ">
                    <form method="post">
                        {{csrf_field()}}
                        <label class="label">Name<span class="primary">*</span></label>
                        <p class="control">
                            <input class="input is-large" type="text" placeholder="Your name" name="name">
                        </p>
                        <label class="label">Email<span class="primary">*</span></label>
                        <p class="control">
                            <input class="input is-large" type="email" placeholder="Your email" name="email">
                        </p>
                        <label class="label">Subject<span class="primary">*</span></label>
                        <p class="control">
                            <input class="input is-large" type="text" placeholder="Subject" name="subject">
                        </p>
                        <label class="label">Your message<span class="primary">*</span></label>
                        <p class="control">
                            <textarea placeholder="Your message..." class="textarea" name="the_message"></textarea>
                        </p>
                        <p>
                            {!! Recaptcha::render() !!}
                        </p>
                        <p class="control m-t-m">
                            <button class="button is-primary is-outlined is-large">Submit</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

