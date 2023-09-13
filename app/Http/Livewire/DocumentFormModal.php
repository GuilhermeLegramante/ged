<?php

namespace App\Http\Livewire;

use App;
use App\Http\Livewire\Traits\WithForm;
use Livewire\Component;

class DocumentFormModal extends Component
{
    use WithForm;

    public $entity;
    public $pageTitle;
    public $icon = 'fas fa-file-alt';
    public $method = 'store';
    public $formTitle;

    protected $repositoryClass = 'App\Repositories\DocumentRepository';

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
        'showDocumentFormModal',
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

    public function showDocumentFormModal($id = null)
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

    public function mount($id = null)
    {
        $this->formTitle = strtoupper('DADOS DO(A) Documento');
        $this->entity = 'document';
        $this->pageTitle = 'Documento';

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
        return view('livewire.document-form-modal');
    }
}
