<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('game.title')</title>
    <link rel="stylesheet" href="{{ asset('css/game.css') }}">
</head>
<body>
<div class="game-page">
    <div class="buttons-container">
        <div class="button-wrapper">
            <form action="{{ route('game.play', $token) }}" method="POST">
                @csrf
                <button type="submit">@lang('game.buttons.play')</button>
            </form>
        </div>

        <div class="button-wrapper">
            <form action="{{ route('game.history', $token) }}" method="GET">
                <button type="submit">@lang('game.buttons.history')</button>
            </form>
        </div>

        <div class="button-wrapper">
            <form action="{{ route('game-link.generate', $token) }}" method="POST">
                @csrf
                <button type="submit">@lang('game.buttons.generate_new_link')</button>
            </form>
        </div>

        <div class="button-wrapper">
            <form action="{{ route('game-link.destroy', $token) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">@lang('game.buttons.deactivate_link')</button>
            </form>
        </div>
    </div>

    @if(session('gameResult'))
        <div class="game-result">
            <p>@lang('game.result.random_number') : {{ session('gameResult.number') }}</p>
            <p>@lang('game.result.result') : {{ session('gameResult.status_label') }}</p>
            <p>@lang('game.result.win_amount'): {{ session('gameResult.win_amount') }}</p>
        </div>
    @endif
</div>

</body>
</html>
