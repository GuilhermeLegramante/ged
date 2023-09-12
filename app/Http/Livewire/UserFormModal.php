<?php

namespace App\Http\Livewire;

use App;
use App\Http\Livewire\Traits\WithForm;
use Livewire\Component;

class UserFormModal extends Component
{
    use WithForm;

    public $entity;
    public $pageTitle;
    public $icon = 'fas fa-list';
    public $method = 'store';
    public $formTitle;

    protected $repositoryClass = 'App\Repositories\UserRepository';

    public $name;
    public $login;
    public $password;
    public $password_confirmation;
    public $email;
    public $isAdmin;

    protected $inputs = [
        ['field' => 'recordId', 'edit' => true],
        ['field' => 'name', 'edit' => true, 'type' => 'string'],
        ['field' => 'login', 'edit' => true, 'type' => 'string'],
        ['field' => 'password', 'edit' => true, 'type' => 'string'],
        ['field' => 'email', 'edit' => true],
        ['field' => 'isAdmin', 'edit' => true],
    ];

    protected $validationAttributes = [
        'name' => 'Nome',
        'login' => 'Login',
        'password' => 'Senha',
        'email' => 'E-mail',
        'isAdmin' => 'Admin',
    ];

    public function rules()
    {
        return [
            'name' => ['required'],
            'login' => ['required'],
            'password' => ['required', 'confirmed'],
            'isAdmin' => ['required'],
            'email' => ['email', 'nullable'],
        ];
    }

    protected $listeners = [
        'showUserFormModal',
    ];

    public function showUserFormModal($id = null)
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

            $this->reset('recordId', 'name', 'login', 'password', 'password_confirmation', 'email', 'isAdmin');
        }
    }

    public function mount($id = null)
    {
        $this->formTitle = strtoupper('DADOS DO(A) Usuário');
        $this->entity = 'user';
        $this->pageTitle = 'Usuário';

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

        $this->login = $data->login;

        $this->isAdmin = $data->isAdmin;

        $this->email = $data->email;
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
        return view('livewire.user-form-modal');
    }
}
