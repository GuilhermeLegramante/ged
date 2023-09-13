<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Traits\WithSelect;
use Livewire\Component;

class DocumentTypeSelect extends Component
{
    use WithSelect;

    public $title = 'Tipo de Documento';
    public $modalId = 'modal-select-document-type';
    public $searchFieldsLabel = 'Código ou Descrição';

    public $closeModal = 'closeDocumentTypeModal';
    public $selectModal = 'selectDocumentType';
    public $showModal = 'showDocumentTypeModal';

    protected $repositoryClass = 'App\Repositories\DocumentTypeRepository';

    public function render()
    {
        $this->insertButtonOnSelectModal = true;

        $this->addMethod = 'showDocumentTypeFormModal';

        $this->search();

        $data = $this->data;

        return view('livewire.document-type-select', compact('data'));
    }
}
