@section('title', config('app.name') . ' - ' . $pageTitle)

@yield('page_header')

@include('partials.flash-messages.default')

@include('partials.spinner.default')

@yield('page_content')

<br>
@section('footer')
@include('partials.footer.page')
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@stop

@section('js')
<script src="{{ asset('js/scripts.js') }}"></script>
<script src="{{ asset('js/livewire-custom.js') }}"></script>
@stop
