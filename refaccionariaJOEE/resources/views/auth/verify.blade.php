    @extends('layouts.app')

    @section('title', 'Verify') @section('content')
<div class="contcard">
    <div class="card">

                <h1>{{ __('Verify Your Email Address') }}</h1>

                <div class="ijeit">
                    @if (session('resent'))
                        <div class="suc" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                </div>

                    <form method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn">{{ __('click here to request another') }}</button>.
                    </form>
            </div>
        </div>
@endsection
