@extends('layouts.app')

@section('title', 'Register') @section('content')
<div class="contcard">
    <div class="card">

                <h1>{{ __('Register') }}</h1>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="ijeit">
                            <label for="nombre">{{ __('Name') }}</label>

                                <input id="nomre" type="text" class="@error('nombre') dan @enderror" name="nombre" value="{{ old('nombre') }}" required autocomplete="nombre" autofocus
                                placeholder="Your name">

                                @error('nombre')
                                    <span class="dan" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="ijeit">
                            <label for="email">{{ __('Email Address') }}</label>
                                <input id="email" type="email" class="@error('email') dan @enderror" name="email" value="{{ old('email') }}" required autocomplete="email"
                                placeholder="example@mail.com">

                                @error('email')
                                    <span class="dan" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="ijeit">
                            <label for="password">{{ __('Password') }}</label>
                                <input id="password" type="password" class=" @error('password') dan @enderror" name="password" required autocomplete="new-password"
                                placeholder="********">

                                @error('password')
                                    <span class="dan" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="ijeit">
                            <label for="password-confirm">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password"
                                placeholder="********">
                            </div>
                        </div>

                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>

                    </form>
                </div>
            </div>
@endsection
