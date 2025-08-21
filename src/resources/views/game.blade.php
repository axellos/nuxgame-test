<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('game.title')</title>
    <link rel="stylesheet" href="{{ asset('css/game.css') }}">
    <link rel="stylesheet" href="{{ asset('css/link-box.css') }}">
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
            <form action="{{ route('game-link.deactivate', $token) }}" method="POST">
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

    @if(session('gameRecords'))
        <div class="game-history">
            <h2>@lang('game.history.title')</h2>

            @if(count(session('gameRecords')) === 0)
                <p>@lang('game.history.no_results')</p>
            @else
                <ul>
                    @foreach(session('gameRecords') as $record)
                        <li>
                            {{ __('game.result.random_number') }}: {{ $record['number'] }},
                            {{ __('game.result.result') }}: {{ $record['status_label'] }},
                            {{ __('game.result.win_amount') }}: {{ $record['win_amount'] }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif

    @if(session('newGameLink'))
        @include('partials._game_link', ['link' => session('newGameLink')])
    @endif
</div>

</body>
</html>
