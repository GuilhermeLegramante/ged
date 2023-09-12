<div class="card card-primary card-outline mt-1">
    <div class="card-header" data-card-widget="collapse">
        <div class="row mt-1">
            <div class="col-md-11">
                <h3 class="card-title cardTitleCustom"><strong> {{ $filterTitle }}</strong>
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
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Busca por Código ou Descrição</label>
                            <input wire:model.lazy="{{ $search }}" type="text"
                                class="form-control input-custom" placeholder="Pesquisar...">
                        </div>
                    </div>
                </div>

                @error("{{ $selected }}")
                    <h3 class="text-danger"><strong>{{ $message }}</strong></h3>
                @enderror

                <div class="maxh-300px table-responsive">
                    <table class="table table-hover table-striped pd-dot3r">
                        <thead>
                            <tr>
                                <th class="text-center w-5">
                                    <input type="checkbox" wire:model.lazy="{{ $checkAll }}">
                                </th>
                                <th wire:click="{{ $sortByCode }}" class="cursor-pointer w-10 text-center">
                                    Código
                                    @if ($filterSortBy !== 'code')
                                        <i style="color: lightgray" class="fas fa-arrow-up fa-xs"></i>
                                        <i style="color: lightgray" class="fas fa-arrow-down fa-xs"></i>
                                    @elseif ($filterSortDirection == 'asc')
                                        <i style="color: black" class="fas fa-arrow-up fa-xs"></i>
                                        <i style="color: lightgray" class="fas fa-arrow-down fa-xs"></i>
                                    @else
                                        <i style="color: lightgray" class="fas fa-arrow-up fa-xs"></i>
                                        <i style="color: black" class="fas fa-arrow-down fa-xs"></i>
                                    @endif
                                </th>
                                <th wire:click="{{ $sortByDescription }}" class="cursor-pointer">
                                    Descrição
                                    @if ($filterSortBy !== 'description')
                                        <i style="color: lightgray" class="fas fa-arrow-up fa-xs"></i>
                                        <i style="color: lightgray" class="fas fa-arrow-down fa-xs"></i>
                                    @elseif ($filterSortDirection == 'asc')
                                        <i style="color: black" class="fas fa-arrow-up fa-xs"></i>
                                        <i style="color: lightgray" class="fas fa-arrow-down fa-xs"></i>
                                    @else
                                        <i style="color: lightgray" class="fas fa-arrow-up fa-xs"></i>
                                        <i style="color: black" class="fas fa-arrow-down fa-xs"></i>
                                    @endif
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox"
                                            wire:model.lazy="{{ $selectedWithDot }}{{ $item['id'] }}"
                                            value="{{ $item['code'] }} - {{ $item['description'] }}">
                                    </td>
                                    <td class="align-middle text-center">
                                        {{ $item['code'] }}
                                    </td>
                                    <td class="align-middle pl-12px">
                                        {{ $item['description'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if (empty($data))
                        <div class="d-flex justify-content-center">
                            <h3>Nenhum registro encontrado.</h3>
                        </div>
                    @endif
                </div>
            </div>

        </div>
        @include('partials.table.more-and-less-buttons', [
            'property' => $filterEntity . 'PerPage',
            'method' => $updatedMethod,
            'data' => $data,
        ])
        <div class="modal-footer">
            <h3>{{ count($data) }} registros</h3>
        </div>
    </div>
</div>
