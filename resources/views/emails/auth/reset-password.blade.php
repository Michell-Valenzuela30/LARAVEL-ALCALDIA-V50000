@component('mail::message')
{{-- Encabezado personalizado con logo --}}
<div class="flex items-center justify-center mb-4">
    <a href="{{ url('/') }}">
        @php
            $logoLight = config('site_config.logo_light', 'Img/Logo/logo_light.svg');
            $logoDark = config('site_config.logo_dark', 'Img/Logo/logo_dark.svg');
        @endphp
        <img src="{{ asset($logoDark) }}" alt="Logo" class="h-10 w-auto mr-2 block dark:hidden"
            onerror="this.src='{{ asset('Img/Logo/logo_light.svg') }}'; this.onerror=null;">
    </a>
</div>

# {{ __('Restablecer contraseña') }}

{{ __('Estás recibiendo este correo porque se ha recibido una solicitud para restablecer la contraseña de tu cuenta.') }}

@component('mail::button', ['url' => $url])
{{ __('Restablecer Contraseña') }}
@endcomponent

{{ __('Si no solicitaste el cambio de contraseña, no es necesario realizar ninguna otra acción.') }}

{{ __('¡Saludos!') }}<br>
{{ config('app.name') }}
@endcomponent
