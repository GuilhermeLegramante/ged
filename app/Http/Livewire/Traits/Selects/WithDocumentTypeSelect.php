<?php

namespace App\Http\Livewire\Traits\Selects;

use App\Repositories\DocumentTypeRepository;
use Illuminate\Support\Facades\App;
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

        array_push($this->inputs,
            [
                'field' => 'documentTypeId',
                'edit' => true,
            ]
        );

        $this->resetValidation('documentTypeId');
    }
}
