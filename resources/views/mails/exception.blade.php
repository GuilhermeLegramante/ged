@component('mail::message')

# Cliente: {{ session()->get('clientName') }}
## Usuário: {{ session()->get('userId') }} - {{ session()->get('username') }}
## URL: {{ $content['url'] }}
## IP: {{ $content['ip'] }}

<p>{{ $content['message'] }} </p>

@endcomponent
