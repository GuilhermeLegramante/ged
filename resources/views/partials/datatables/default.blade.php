<div class="card card-primary card-outline">
    <div class="card-header mt-2">
        @include('partials.table.search')

    </div>
    <div class="card-body mb-n2">
        <div class="row">
            @include('partials.inputs.column-list', [
            'columnSize' => 12,
            'label' => 'Colunas',
            'model' => $headerColumns,
            ])
        </div>
        <div class="table-responsive">
            <table class="pd-dot3r table table-hover table-striped">
                @include('partials.table.header')
                @include('partials.table.body')
            </table>
        </div>
        @include('partials.table.links')
    </div>
</div>
