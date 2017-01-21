@section('title', 'Reset Password')
@extends('layout.master')

@section('content')
    <section class="m-t-l p-l fade-in">
        <div class="container">
            <div class="columns">
                <div class="column is-half-desktop is-offset-one-quarter">
                    @include('layout.feedback')
                    <div class="box ">
                        <form method="post" role="form" method="POST" action="{{ url('/password/reset') }}">

                            {{csrf_field()}}
                            <input type="hidden" name="token" value="{{ $token }}">

                            <label class="label">E-Mail Address<span class="primary">*</span></label>
                            <p class="control">
                                <input id="email" type="email" class="input is-large" name="email"
                                       value="{{ $email or old('email') }}" required autofocus>
                            </p>

                            <label class="label">Password<span class="primary">*</span></label>
                            <p class="control">
                                <input id="password" type="password" class="input is-large" name="password" required>
                            </p>

                            <label class="label">Confirm Password<span class="primary">*</span></label>
                            <p class="control">
                                <input id="password-confirm" type="password" class="input is-large" name="password_confirmation" required>
                            </p>

                            <p>
                                {!! Recaptcha::render() !!}
                            </p>

                            <p class="control m-t-m">
                                <button class="button is-primary is-outlined is-large">Reset Password</button>
                            </p>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
