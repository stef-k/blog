@section('title', 'Reset Password')
@extends('layout.master')

@section('content')
    <section class="m-t-l p-l fade-in">
        <div class="container">
            <div class="columns">
                <div class="column is-half-desktop is-offset-one-quarter">
                    @include('layout.feedback')
                    <div class="box ">
                        <form method="post" role="form" method="POST" action="{{ url('/password/email') }}">
                            {{csrf_field()}}
                            <label class="label">E-Mail Address<span class="primary">*</span></label>
                            <p class="control">
                                <input id="email" type="email" class="input is-large" name="email"
                                       value="{{ old('email') }}" required autofocus>
                            </p>

                            <p>
                                {!! Recaptcha::render() !!}
                            </p>

                            <p class="control m-t-m">
                                <button class="button is-primary is-outlined is-large">Send Password Reset Link</button>
                            </p>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
