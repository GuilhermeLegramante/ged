<div wire:ignore.self class="modal fade z-index-99999" id="document-filter-modal" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <p>
                    <strong>FILTROS</strong>
                </p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                @include('partials.flash-messages.default')

                @include('partials.spinner.default')

                <div class="row">
                    @include('partials.inputs.text', [
                    'columnSize' => 12,
                    'label' => 'Descrição',
                    'model' => 'note',
                    ])
                </div>
                <div class="row">
                    @include('partials.inputs.text', [
                    'columnSize' => 12,
                    'label' => 'Número',
                    'model' => 'number',
                    ])
                </div>
                <div class="row">
                    @include('partials.inputs.date', [
                    'columnSize' => 4,
                    'label' => 'Data do Documento',
                    'model' => 'date',
                    ])
                    @include('partials.inputs.date', [
                    'columnSize' => 4,
                    'label' => 'Início da Vigência',
                    'model' => 'validityStart',
                    ])
                    @include('partials.inputs.date', [
                    'columnSize' => 4,
                    'label' => 'Fim da Vigência',
                    'model' => 'validityEnd',
                    ])
                </div>
                <div class="row">
                    @include('partials.inputs.select-modal', [
                    'columnSize' => 12,
                    'label' => 'Tipo de Documento',
                    'method' => 'showDocumentTypeSelectModal',
                    'model' => 'documentTypeId',
                    'description' => $documentTypeDescription,
                    'modelId' => $documentTypeId,
                    'cleanFields' => 'documentTypeId,documentTypeDescription',
                    ])
                </div>

                <div class="row">
                    @include('partials.inputs.select-modal', [
                    'columnSize' => 12,
                    'label' => 'Pessoa(s) Relacionada(s)',
                    'method' => 'showPersonSelectModal',
                    'model' => 'personId',
                    'description' => $personDescription,
                    'modelId' => $personId,
                    'cleanFields' => 'personId,personDescription',
                    ])
                </div>
                <div class="row mt-1">
                    @include('partials.inputs.text', [
                    'columnSize' => 12,
                    'label' => 'Tag(s)',
                    'model' => 'tag',
                    ])
                </div>
                <div class="row">
                    @include('partials.inputs.badge-list', [
                    'columnSize' => 12,
                    'label' => '',
                    'model' => $tags,
                    ])
                </div>

                <div class="modal-footer">
                    @include('partials.buttons.filter-actions')
                </div>
            </div>
        </div>
    </div>
</div>
