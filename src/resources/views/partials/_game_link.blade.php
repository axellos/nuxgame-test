@if(!empty($link))
    <div class="link-box">
        <p><strong>@lang('partials.link.title'):</strong></p>
        <a href="{{ $link }}" target="_blank">{{ $link }}</a>
        <p>@lang('partials.link.description')</p>
    </div>
@endif
