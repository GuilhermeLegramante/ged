<?php

namespace App\Http\Livewire;

use App;
use App\Http\Livewire\Traits\WithForm;
use App\Services\Mask;
use Livewire\Component;

class PersonFormModal extends Component
{
    use WithForm;

    public $entity;
    public $pageTitle;
    public $icon = 'fas fa-user-friends';
    public $method = 'store';
    public $formTitle;

    protected $repositoryClass = 'App\Repositories\PersonRepository';

    public $name;
    public $document;
    public $email;
    public $phone;

    public $inputs = [
        [
            'field' => 'recordId',
            'edit' => true,
        ],
        [
            'field' => 'name',
            'edit' => true,
            'type' => 'string',
        ],
        [
            'field' => 'document',
            'edit' => true,
        ],
        [
            'field' => 'email',
            'edit' => true,
        ],
        [
            'field' => 'phone',
            'edit' => true,
        ],
    ];

    protected $listeners = [
        'showPersonFormModal',
    ];

    protected $validationAttributes = [
        'name' => 'Nome',
        'document' => 'Documento',
        'email' => 'E-mail',
        'phone' => 'Telefone',
    ];

    public function rules()
    {
        return [
            'name' => ['required'],
            // 'document' => ['required'],
        ];
    }

    public function showPersonFormModal($id = null)
    {
        $this->reset('recordId', 'name');

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

    public function updatedDocument()
    {
        $this->document = Mask::cpfCnpj($this->document);
    }

    public function updatedPhone()
    {
        $this->phone = Mask::phone($this->phone);
    }

    public function mount($id = null)
    {
        $this->formTitle = strtoupper('DADOS DO(A) Pessoa');
        $this->entity = 'person';
        $this->pageTitle = 'Pessoa';

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

        $this->name = $data->name;
        $this->document = $data->personalDocumentNumber;
        $this->email = $data->email;
        $this->phone = $data->phone;
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
        return view('livewire.person-form-modal');
    }
}
