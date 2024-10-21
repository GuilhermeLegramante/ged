<div class="row mb-n3">
    <div class="col-md-12">
        <div class="form-group">
            <label>Arquivo*</label>
        </div>
    </div>
</div>
<div wire:ignore x-data x-init="() => {
    const post = FilePond.create($refs.input);
    post.setOptions({
    allowMultiple: false,
    preview: true,
    server: {
    process:(fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
    @this.upload('file', file, load, error, progress);
    },
    revert: (filename, load) => {
    @this.removeUpload('file', filename, load)
    },
    }
    });
}">
    <input type=" file" x-ref="input" />
</div>
@error('file')
<h3 class="text-danger mt-n1 mb-4">
    <strong>{{ $message }}</strong>
</h3>
@enderror
@if(isset($storedFilePath))
<div class="mb-3">
    <div class="mr-1">
        <small class="cursor-pointer badge badge-primary mt-1">
            <a class="cursor-pointer badge badge-primary" target="_blank" href="{{ Storage::disk('s3')->url($storedFilePath) }}">VISUALIZAR O ARQUIVO</a>
            <i class="fas fa-paperclip"></i>
        </small>
    </div>
</div>
@endif
<div class="row">
    @include('partials.inputs.text', [
    'columnSize' => 12,
    'label' => 'Descrição*',
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
<div class="row">
    @include('partials.inputs.person-badge-list', [
    'columnSize' => 12,
    'label' => '',
    'model' => $persons,
    ])
</div>

<div class="row mt-1">
    @include('partials.inputs.select-modal', [
    'columnSize' => 12,
    'label' => 'Pasta',
    'method' => 'showFolderSelectModal',
    'model' => 'folderId',
    'description' => $folderDescription,
    'modelId' => $folderId,
    'cleanFields' => 'folderId,folderDescription',
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
<p><small>*campos obrigatórios</small></p>
