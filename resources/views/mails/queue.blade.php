@component('mail::message')

# Cliente: {{ Session::get('client') }}
## Usuário: {{ Session::get('userId') }} - {{ Session::get('username') }}
## FILA: {{ $content['queueName'] }}

<p>{{ $content['url'] }} </p>

@endcomponent
