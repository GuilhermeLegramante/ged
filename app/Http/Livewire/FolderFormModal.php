<?php

namespace App\Http\Livewire;

use App;
use App\Http\Livewire\Traits\WithForm;
use Livewire\Component;

class FolderFormModal extends Component
{
    use WithForm;

    public $entity;
    public $pageTitle;
    public $icon = 'fas fa-list';
    public $method = 'store';
    public $formTitle;

    public $refreshAfterAction = false;

    protected $repositoryClass = 'App\Repositories\FolderRepository';

    public $description;

    public $inputs = [
        [
            'field' => 'recordId',
            'edit' => true
        ],
        [
            'field' => 'description',
            'edit' => true,
            'type' => 'string'
        ],
    ];

    protected $listeners = [
        'showFolderFormModal',
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

    public function showFolderFormModal($id = null)
    {
        $this->reset('recordId', 'description');

        $this->resetValidation();

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

    public function mount($id = null, $refreshAfterAction = false)
    {
        $this->formTitle = strtoupper('DADOS DO(A) Pasta');
        $this->entity = 'folder';
        $this->pageTitle = 'Pasta';

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
        return view('livewire.folder-form-modal');
    }
}
