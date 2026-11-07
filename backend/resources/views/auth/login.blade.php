    @extends('layouts.app')

    @section('title', 'Login') @section('content')
    <div class="contcard">
    <div class="card">
        
                    <h1>{{ __('Login') }}</h1>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="ijeit">
                                <label for="email">{{ __('Email Address') }}</label>
                                    <input id="email" type="email" class="@error('email') dan @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                    placeholder="example@mail.com">

                                    @error('email')
                                        <span class="dan" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                

                            <div class="ijeit">
                                <label for="password">{{ __('Password') }}</label>
                                    <input id="password" type="password" class="@error('password') dan @enderror" name="password" required autocomplete="current-password"
                                    placeholder="************">

                                    @error('password')
                                        <span class="dan" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>

                            <div class="ijeit">
                                    
                                <div class="form-group-checkbox">
                                    <label class="custom-checkbox">
                                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <span class="checkmark"></span>
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>

                            </div>

                                    <button type="submit" class="btn">
                                        {{ __('Login') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                            <a class="yousaidsmt" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                    </form>
        </div>
    </div>
    @endsection
