@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Salam Hangat!')
@else
# @lang('Salam Hangat!')
@endif
@endif

@php
echo '<div style="width:100%; margin-bottom:10px" align="center"><a href="https://langkaheducation.com/" target="_blank"><img alt="Logo" src="https://www.langkaheducation.com/assets/img/logo-primary.png" width="50%" style="display: block; font-family: Helvetica, Arial, sans-serif; color: #666666; font-size: 16px;" border="0"></a></div>';  

echo'<img style="margin-bottom:10px" src="https://langkaheducation.com/assets/img/email-verification.png" border="0" alt="illustration" style="display: block; padding: 0; color: #666666; text-decoration: none; font-family: Helvetica, arial, sans-serif; font-size: 16px; width: 500px;" class="img-max">';
@endphp

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Terima Kasih telah menghubungi kami'),<br>
{{ config('app.name') }}
@endif

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(
    "Jika kamu mengalami masalah klik tombol \":actionText\", dan copy paste\n".
    'pada browser secara manual:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
@endslot
@endisset
@endcomponent