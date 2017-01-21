@section('title', 'Register')
@extends('layout.master')

@section('content')
    <section class="m-t-l p-l fade-in">
        <div class="container">
            <div class="columns">
                <div class="column is-half-desktop is-offset-one-quarter">
                    @include('layout.feedback')
                    <div class="box ">
                        <form method="post" role="form" method="POST" action="{{ url('/register') }}">
                            {{csrf_field()}}
                            <label class="label">Name<span class="primary">*</span></label>
                            <p class="control">
                                <input id="name" type="text" class="input is-large" name="name"
                                       value="{{ old('name') }}" required autofocus>
                            </p>


                            <label class="label">E-Mail Address<span class="primary">*</span></label>
                            <p class="control">
                                <input id="email" type="email" class="input is-large" name="email"
                                       value="{{ old('email') }}" required>
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
                                <button type="submit" class="button is-primary is-outlined is-large">Register</button>
                            </p>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
