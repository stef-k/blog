@section('title', 'Login')
@extends('layout.master')

@section('content')
    <section class="m-t-l p-l fade-in">
        <div class="container">
            <div class="columns">
                <div class="column is-half-desktop is-offset-one-quarter">
                    @include('layout.feedback')
                    <div class="box ">
                        <form method="post" role="form" method="POST" action="{{ url('/login') }}">
                            {{csrf_field()}}
                            <label class="label">E-Mail Address<span class="primary">*</span></label>
                            <p class="control">
                                <input id="email" type="email" class="input is-large" name="email"
                                       value="{{ old('email') }}" required autofocus>
                            </p>

                            <label class="label">Password<span class="primary">*</span></label>
                            <p class="control">
                                <input id="password" type="password" class="input is-large" name="password" required>
                            </p>


                            <p class="control">
                                <label class="checkbox is-large">
                                    <input type="checkbox" {{ old('remember') ? 'checked' : ''}}>
                                    Remember me
                                </label>
                            </p>

                            <p>
                                {!! Recaptcha::render() !!}
                            </p>


                            <p class="control m-t-m">
                                <button class="button is-primary is-outlined is-large">Submit</button>
                                <a class="button button-link is-large is-pulled-right" href="{{ url('/password/reset') }}">
                                    Forgot Your Password?
                                </a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
