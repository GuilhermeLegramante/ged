@extends('template.page')

@section('page_header')
@include('partials.header.default')
@endsection

@section('page_content')
<div wire:ignore.self class="card card-primary card-outline">
    @include('partials.header.filter-card-header')
    <div class="card-body">
        <div class="row">
            @include('partials.inputs.date', [
            'columnSize' => 3,
            'label' => 'Data Inicial',
            'model' => 'initialDate',
            ])
            @include('partials.inputs.date', [
            'columnSize' => 3,
            'label' => 'Data Final',
            'model' => 'finalDate',
            ])
        </div>

        @include('partials.cards.aditional-filter-label')

        @include('partials.filters.checkbox', [
        'label' => 'USUÁRIOS',
        'method' => 'showUsersFilter'
        ])

        @include('partials.filters.checkbox', [
        'label' => 'AGRUPAR POR USUÁRIO',
        'method' => 'groupReportByUser'
        ])

        @include('partials.cards.show-resume-filter')
    </div>
</div>

@if ($showUsersFilter)
@include('partials.filters.master', [
'filterTitle' => 'USUÁRIOS',
'filterSortBy' => $usersSortBy,
'filterSortDirection' => $usersSortDirection,
'filterEntity' => 'users',
'sortByCode' => "usersSortBy('code')",
'sortByDescription' => "usersSortBy('description')",
'data' => $users,
'search' => 'usersSearch',
'selected' => 'selectedUsers',
'filterPerPage' => 'usersPerPage',
'updatedMethod' => 'updatedSearchUser',
'selectedWithDot' => 'selectedUsers.',
'checkAll' => 'checkAllUsers',
])
@endif


@include('partials.filters.resume', [
'singles' => [
['title' => 'Data Inicial', 'model' => $initialDate, 'type' => 'date'],
],
'collections' => [
['data' => $selectedUsers, 'title' => 'USUÁRIOS'],
],
])

@if($showDataReport)
<div class="card card-primary card-outline mt-1">
    <div class="card-header" data-card-widget="collapse">
        <div class="row mt-1">
            <div class="col-md-11">
                <h3 class="card-title cardTitleCustom"><strong> DADOS DO RELATÓRIO</strong>
                </h3>
            </div>
        </div>
        <div class="card-tools mt-n2">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>

    @if ($groupReportByUser)
    <div class="card-body">
        @foreach ($reportData as $key => $value)
        <div class="table-responsive">
            <table class="table-bordered table-striped pd-10px w-100">
                <tbody>
                    <tr>
                        <th class="p-1">Usuário</th>
                        <td class="p-1">{{ $key }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <div class="table-responsive">
            <table class="pd-dot3r table table-hover table-striped">
                <thead>
                    <tr>
                        <th class="text-center w-10">
                            Número
                        </th>
                        <th class="w-70">
                            Descrição
                        </th>
                        <th class="text-center w-15">
                            Data de Inclusão
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($value as $item)
                    <tr>
                        <td class="text-center align-middle">
                            {{ $item['number'] }}
                        </td>
                        <td class="pl-12px">
                            {{ $item['description'] }}
                        </td>
                        <td class="text-center align-middle">
                            {{ date('d/m/Y H:i:s', strtotime($item['createdAt']) ) }}
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td class="text-right" colspan="2">
                            <strong>Total de Documentos Cadastrados</strong>
                        </td>
                        <td class="text-center align-middle">
                            <strong>{{ count($value) }}</strong>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <hr>
        @endforeach
    </div>
    @else
    <div class="card-body">
        <div class="table-responsive">
            <table class="pd-dot3r table table-hover table-striped">
                <thead>
                    <tr>
                        <th class="text-center w-10">
                            Número
                        </th>
                        <th class="w-70">
                            Descrição
                        </th>
                        <th class="text-center w-15">
                            Data de Inclusão
                        </th>
                        <th class="text-center w-20">
                            Usuário
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reportData as $item)
                    <tr>
                        <td class="text-center align-middle">
                            {{ $item['number'] }}
                        </td>
                        <td class="pl-12px">
                            {{ $item['description'] }}
                        </td>
                        <td class="text-center align-middle">
                            {{ date('d/m/Y H:i:s', strtotime($item['createdAt']) ) }}
                        </td>
                        <td class="text-center align-middle">
                            {{ $item['username'] }}
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td class="text-right" colspan="3">
                            <strong>Total de Documentos Cadastrados</strong>
                        </td>
                        <td class="text-center align-middle">
                            <strong>{{ count($reportData) }}</strong>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @endif


</div>
@endif

@include('partials.cards.generate-report-button')
@endsection
