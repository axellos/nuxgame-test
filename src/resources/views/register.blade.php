<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ session('gameLink') ? __('registration.link.title') : __('registration.title') }}</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet" href="{{ asset('css/link-box.css') }}">
</head>
<body>
<div class="container">
    @if(!session('gameLink'))
        <h2>@lang('registration.title')</h2>
    @endif

    @if(session('gameLink'))
        @include('partials._game_link', ['link' => session('gameLink')])
    @else
    <form method="POST" action="{{ route('register.submit') }}">
        @csrf

        <div class="input-group">
            <label for="username">@lang('registration.username'):</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}">
            @error('username')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="input-group">
            <label for="phone_number">@lang('registration.phone_number'):</label>
            <input type="tel" id="phone_number" name="phone_number" placeholder="+1234567890" title="{{__('registration.phone_number_help')}}" pattern="^\+?\d{10,15}$" value="{{ old('phone_number') }}">
            @error('phone_number')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">@lang('registration.submit')</button>
    </form>
    @endif
</div>
</body>
</html>
