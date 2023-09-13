<?php

namespace App\Http\Livewire\Traits\Selects;

use Illuminate\Support\Facades\App;
use App\Repositories\DocumentTypeRepository;
use Str;

trait WithDocumentTypeSelect
{
    public $documentTypeId;

    public $documentTypeDescription;

    public function selectDocumentType($id)
    {
        $repository = App::make(DocumentTypeRepository::class);

        $data = $repository->findById($id);

        $this->documentTypeId = $data->id;

        $this->documentTypeDescription = Str::words($data->description, 5);

        $this->resetValidation('documentTypeId');
    }
}
