@if ($data->isEmpty())
    <div class="d-flex justify-content-center">
        <h3>Nenhum registro encontrado.</h3>
    </div>
@else
    @if ($data->lastItem() != $data->total())
        <div class="row">
            <div class="col-12 text-center">
                <a href="#topo" data-toggle="tooltip" title="VOLTAR AO TOPO"
                    class="btn btn-primary btn-sm">
                    <i class="fas fa-chevron-up"></i>
                </a>
                <a href="" wire:click.prevent="load('30')" data-toggle="tooltip" title="VER MAIS"
                    class="btn btn-primary btn-sm">
                    <i class="fas fa-chevron-down"></i>
                </a>
                {{-- <a wire:click="load('30')" data-toggle="tooltip" title="VER MAIS"
                    class="btn btn-primary btn-sm">
                    <i class="fas fa-chevron-down"></i>
                </a> --}}
            </div>
        </div>
    @endif

    <div class="d-flex mb-3">
        <div class="mr-auto">
            <p>Mostrando de {{ $data->firstItem() }} até {{ $data->lastItem() }} de
                {{ $data->total() }} registros.</p>
        </div>
        <div class="p-2">
            <p>{{ $data->links() }}</p>
        </div>
    </div>
@endif
