<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Components\Button;
use App\Http\Livewire\Traits\WithDatatable;
use App\Services\SessionService;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use Livewire\WithPagination;

class DocumentTable extends Component
{
    use WithDatatable, WithPagination;

    public $entity;
    public $pageTitle;
    public $icon = 'fas fa-file-alt';
    public $searchFieldsLabel = 'Código ou Descrição';
    public $hasForm = true;
    public $formModalEmitMethod = 'showDocumentFormModal';
    public $formType = 'modal';

    public $headerColumns = [
        [
            'field' => 'id',
            'label' => 'Código',
            'css' => 'text-center w-10',
            'visible' => 'true',
        ],
        [
            'field' => 'note',
            'label' => 'Descrição',
            'css' => 'w-40',
            'visible' => 'true',
        ],
        [
            'field' => 'path',
            'label' => 'Arquivo',
            'css' => 'w-40',
            'visible' => 'true',
        ],
        [
            'field' => 'number',
            'label' => 'Número',
            'css' => 'w-10',
            'visible' => 'true',
        ],
        [
            'field' => 'date',
            'label' => 'Data do Documento',
            'css' => 'w-10',
            'visible' => 'true',
        ],
        [
            'field' => 'validityStart',
            'label' => 'Início da Vigência',
            'css' => 'w-10',
            'visible' => 'true',
        ],
        [
            'field' => 'validityEnd',
            'label' => 'Fim da Vigência',
            'css' => 'w-10',
            'visible' => 'true',
        ],
        [
            'field' => 'createdAt',
            'label' => 'Incluído em',
            'css' => 'w-10',
            'visible' => 'true',
        ],
        [
            'field' => 'updatedAt',
            'label' => 'Editado em',
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
            'field' => 'note',
            'type' => 'string',
            'css' => 'pl-12px',
            'visible' => 'true',
            'editable' => 'true',
        ],
        [
            'field' => 'path',
            'type' => 'link',
            'css' => 'pl-12px',
            'visible' => 'true',
            'editable' => 'false',
        ],
        [
            'field' => 'number',
            'type' => 'string',
            'css' => 'pl-12px',
            'visible' => 'true',
            'editable' => 'true',
        ],
        [
            'field' => 'date',
            'type' => 'date',
            'css' => 'pl-12px',
            'visible' => 'true',
            'editable' => 'true',
        ],
        [
            'field' => 'validityStart',
            'type' => 'date',
            'css' => 'pl-12px',
            'visible' => 'true',
            'editable' => 'true',
        ],
        [
            'field' => 'validityEnd',
            'type' => 'date',
            'css' => 'pl-12px',
            'visible' => 'true',
            'editable' => 'true',
        ],
        [
            'field' => 'createdAt',
            'type' => 'timestamps',
            'css' => 'pl-12px',
            'visible' => 'true',
            'editable' => 'false',
        ],
        [
            'field' => 'updatedAt',
            'type' => 'timestamps',
            'css' => 'pl-12px',
            'visible' => 'true',
            'editable' => 'false',
        ],
    ];

    protected $repositoryClass = 'App\Repositories\DocumentRepository';

    public function mount()
    {
        $this->entity = 'document';
        $this->pageTitle = 'Documento';

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

        return view('livewire.document-table', compact('data', 'buttons'));
    }
}
