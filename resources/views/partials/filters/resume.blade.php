@if ($showFiltersResume)
    <div class="card card-primary card-outline mt-1">
        <div class="card-header" data-card-widget="collapse">
            <div class="row mt-1">
                <div class="col-md-11">
                    <h3 class="card-title cardTitleCustom"><strong> RESUMO DOS FILTROS APLICADOS</strong>
                    </h3>
                </div>
            </div>
            <div class="card-tools mt-n2">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table-bordered table-striped pd-10px w-100">
                    <tbody>
                        @isset($initialDate)
                        <tr>
                            <th class="p-1">Data Inicial</th>
                            <td class="p-1">{{ date('d/m/Y', strtotime($initialDate)) }}</td>
                        </tr>
                        @endisset
                        @isset($finalDate)
                        <tr>
                            <th class="p-1">Data Final</th>
                            <td class="p-1">{{ date('d/m/Y', strtotime($finalDate)) }}</td>
                        </tr>
                        @endisset
                    </tbody>
                </table>
            </div>

            @foreach ($collections as $collection)
                @if (count($collection['data']) > 0)
                    <div class="maxh-300px table-responsive mt-4">
                        <table class="table table-hover table-striped pd-dot3r">
                            <thead>
                                <tr>
                                    <th colspan="3">
                                        <strong>{{ $collection['title'] }}</strong>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($collection['data'] as $item)
                                    <tr>
                                        <td class="align-middle pl-12px">
                                            {{ $item }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endif
