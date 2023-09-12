@extends('adminlte::page')

@section('content')
<div>
    @livewire('user-form', ['id' => $id])
</div>
@endsection
