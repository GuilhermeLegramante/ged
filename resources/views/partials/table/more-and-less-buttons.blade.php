@if (count($data) > 0)
    <div class="row mb-2">
        <div class="col-12 text-center">
            <a wire:click="increaseOrDecreasePagination('-30', `{{ $property }}`, `{{ $method }}`)" data-toggle="tooltip" title="VER MENOS"
                    class="btn btn-primary btn-sm">
                    <i class="fas fa-chevron-up bg-primary"></i>
                </a>
            <a wire:click="increaseOrDecreasePagination('30', `{{ $property }}`, `{{ $method }}`)" data-toggle="tooltip" title="VER MAIS" class="btn btn-primary btn-sm">
                <i class="fas fa-chevron-down bg-primary"></i>
            </a>
        </div>
    </div>
@endif
