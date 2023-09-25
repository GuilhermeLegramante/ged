<?php

namespace App\Http\Livewire;

use App;
use App\Http\Livewire\Traits\WithForm;
use Livewire\Component;

class DocumentTypeFormModal extends Component
{
    use WithForm;

    public $entity;
    public $pageTitle;
    public $icon = 'fas fa-list';
    public $method = 'store';
    public $formTitle;

    public $refreshAfterAction = false;

    protected $repositoryClass = 'App\Repositories\DocumentTypeRepository';

    public $description;

    protected $inputs = [
        [
            'field' => 'recordId',
            'edit' => true,
        ],
        [
            'field' => 'description',
            'edit' => true,
            'type' => 'string',
        ],
    ];

    protected $listeners = [
        'showDocumentTypeFormModal',
    ];

    protected $validationAttributes = [
        'description' => 'Descrição',
    ];

    public function rules()
    {
        return [
            'description' => ['required'],
        ];
    }

    public function showDocumentTypeFormModal($id = null)
    {
        if (isset($id)) {
            $this->method = 'update';

            $this->isEdition = true;

            $repository = App::make($this->repositoryClass);

            $data = $repository->findById($id);

            if (isset($data)) {
                $this->setFields($data);
            }
        } else {
            $this->isEdition = false;

            $this->reset('recordId', 'description');
        }
    }

    public function mount($id = null, $refreshAfterAction = false)
    {
        $this->formTitle = strtoupper('DADOS DO(A) Tipo de Documento');
        $this->entity = 'document-type';
        $this->pageTitle = 'Tipo de Documento';

        $this->refreshAfterAction = $refreshAfterAction;

        if (isset($id)) {
            $this->method = 'update';

            $this->isEdition = true;

            $repository = App::make($this->repositoryClass);

            $data = $repository->findById($id);

            if (isset($data)) {
                $this->setFields($data);
            }
        }
    }

    public function setFields($data)
    {
        $this->recordId = $data->id;

        $this->description = $data->description;
    }

    public function customValidate()
    {
        return true;
    }

    public function customDeleteValidate()
    {
        return true;
    }

    public function render()
    {
        return view('livewire.document-type-form-modal');
    }
}
