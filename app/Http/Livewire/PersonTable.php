<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Components\Button;
use App\Http\Livewire\Traits\WithDatatable;
use App\Services\SessionService;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use Livewire\WithPagination;

class PersonTable extends Component
{
    use WithDatatable, WithPagination;

    public $entity;
    public $pageTitle;
    public $icon = 'fas fa-user-friends';
    public $searchFieldsLabel = 'Código, Documento ou Nome';
    public $hasForm = true;
    public $formModalEmitMethod = 'showPersonFormModal';
    public $formType = 'modal';

    public $headerColumns = [
        [
            'field' => 'id',
            'label' => 'Código',
            'css' => 'text-center w-10',
            'visible' => 'true',
        ],
        [
            'field' => 'personalDocumentNumber',
            'label' => 'Documento',
            'css' => 'w-15',
            'visible' => 'true',
        ],
        [
            'field' => 'name',
            'label' => 'Nome',
            'css' => 'w-30',
            'visible' => 'true',
        ],
        [
            'field' => 'email',
            'label' => 'E-mail',
            'css' => 'w-20',
            'visible' => 'true',
        ],
        [
            'field' => 'phone',
            'label' => 'Telefone',
            'css' => 'w-10',
            'visible' => 'true',
        ],
        [
            'field' => null,
            'label' => 'Ações',
            'css' => 'text-center w-5',
            'visible' => 'true',
        ],
    ];

    public $bodyColumns = [
        [
            'field' => 'id',
            'type' => 'string',
            'css' => 'text-center',
            'visible' => 'true',
            'editable' => 'false',
        ],
        [
            'field' => 'personalDocumentNumber',
            'type' => 'string',
            'css' => 'pl-12px',
            'visible' => 'true',
            'editable' => 'false',
        ],
        [
            'field' => 'name',
            'type' => 'string',
            'css' => 'pl-12px',
            'visible' => 'true',
            'editable' => 'true',
        ],
        [
            'field' => 'email',
            'type' => 'string',
            'css' => 'pl-12px',
            'visible' => 'true',
            'editable' => 'true',
        ],
        [
            'field' => 'phone',
            'type' => 'string',
            'css' => 'pl-12px',
            'visible' => 'true',
            'editable' => 'true',
        ],
    ];

    protected $repositoryClass = 'App\Repositories\PersonRepository';

    public function mount()
    {
        $this->entity = 'person';
        $this->pageTitle = 'Pessoa';

        SessionService::start();
    }

    public function rowButtons(): array
    {
        return [
            Button::create('Selecionar')
                ->method('showForm')
                ->class('btn-primary')
                ->icon('fas fa-search'),
        ];
    }

    public function render()
    {
        $repository = App::make($this->repositoryClass);

        $data = $repository->all($this->search, $this->sortBy, $this->sortDirection, $this->perPage);

        if ($data->total() == $data->lastItem()) {
            $this->emit('scrollTop');
        }

        $buttons = $this->rowButtons();

        return view('livewire.person-table', compact('data', 'buttons'));
    }
}
