<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Components\Button;
use App\Http\Livewire\Traits\Selects\WithDocumentTypeSelect;
use App\Http\Livewire\Traits\Selects\WithPersonSelect;
use App\Http\Livewire\Traits\WithDatatable;
use App\Services\SessionService;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use Livewire\WithPagination;

class DocumentTable extends Component
{
    use WithDatatable, WithPagination, WithDocumentTypeSelect, WithPersonSelect;

    public $entity;
    public $pageTitle;
    public $icon = 'fas fa-file-alt';
    public $searchFieldsLabel = 'Código, Descrição, Número, TAG ou Pessoa Relacionada';
    public $hasForm = true;
    public $formModalEmitMethod = 'showDocumentFormModal';
    public $formType = 'modal';

    public $hasTableFilters = true;
    public $tableFiltersModalEmit = 'showDocumentFilterModal';

    public $persons = [];
    public $tags = [];
    public $filters = [];
    public $inputs = [];
    public $tag;
    public $note;
    public $number;
    public $date;
    public $validityStart;
    public $validityEnd;


    public $headerColumns = [
        [
            'field' => 'id',
            'label' => 'Código',
            'css' => 'text-center w-10',
            'visible' => true,
        ],
        [
            'field' => 'number',
            'label' => 'Número',
            'css' => 'w-10',
            'visible' => true,
        ],
        [
            'field' => 'note',
            'label' => 'Descrição',
            'css' => 'w-40',
            'visible' => true,
        ],
        [
            'field' => 'path',
            'label' => 'Arquivo',
            'css' => 'w-40',
            'visible' => true,
        ],
        [
            'field' => 'date',
            'label' => 'Data do Documento',
            'css' => 'w-10',
            'visible' => true,
        ],
        [
            'field' => 'validityStart',
            'label' => 'Início da Vigência',
            'css' => 'w-10',
            'visible' => false,
        ],
        [
            'field' => 'validityEnd',
            'label' => 'Fim da Vigência',
            'css' => 'w-10',
            'visible' => false,
        ],
        [
            'field' => 'createdAt',
            'label' => 'Incluído em',
            'css' => 'w-10',
            'visible' => false,
        ],
        [
            'field' => 'updatedAt',
            'label' => 'Editado em',
            'css' => 'w-10',
            'visible' => false,
        ],
        [
            'field' => null,
            'label' => 'Ações',
            'css' => 'text-center w-5',
            'visible' => true,
        ],
    ];

    public $bodyColumns = [
        [
            'field' => 'id',
            'type' => 'string',
            'css' => 'text-center',
            'visible' => true,
            'editable' => 'false',
        ],
        [
            'field' => 'number',
            'type' => 'string',
            'css' => 'pl-12px',
            'visible' => true,
            'editable' => true,
        ],
        [
            'field' => 'note',
            'type' => 'string',
            'css' => 'pl-12px',
            'visible' => true,
            'editable' => true,
        ],
        [
            'field' => 'path',
            'type' => 'link',
            'css' => 'pl-12px',
            'visible' => true,
            'editable' => 'false',
        ],

        [
            'field' => 'date',
            'type' => 'date',
            'css' => 'pl-12px',
            'visible' => true,
            'editable' => false,
        ],
        [
            'field' => 'validityStart',
            'type' => 'date',
            'css' => 'pl-12px',
            'visible' => false,
            'editable' => false,
        ],
        [
            'field' => 'validityEnd',
            'type' => 'date',
            'css' => 'pl-12px',
            'visible' => false,
            'editable' => false,
        ],
        [
            'field' => 'createdAt',
            'type' => 'timestamps',
            'css' => 'pl-12px',
            'visible' => false,
            'editable' => false,
        ],
        [
            'field' => 'updatedAt',
            'type' => 'timestamps',
            'css' => 'pl-12px',
            'visible' => false,
            'editable' => false,
        ],
    ];

    protected $repositoryClass = 'App\Repositories\DocumentRepository';

    protected $listeners = [
        'selectDocumentType',
        'selectPerson',
    ];

    public function mount()
    {
        $this->entity = 'document';
        $this->pageTitle = 'Documento';

        $this->sortBy = 'id';
        $this->sortDirection = 'desc';

        SessionService::start();
        dd('a');
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

        if (count($this->filters) > 0) {
            $data = $repository->allWithFilter($this->filters, $this->sortBy, $this->sortDirection, $this->perPage);
        }

        if ($data->total() == $data->lastItem()) {
            $this->emit('scrollTop');
        }

        $buttons = $this->rowButtons();

        return view('livewire.document-table', compact('data', 'buttons'));
    }

    public function setFilters()
    {
        $this->filters = [
            'note' => $this->note,
            'number' => $this->number,
            'date' => $this->date,
            'validityStart' => $this->validityStart,
            'validityEnd' => $this->validityEnd,
            'documentTypeId' => $this->documentTypeId,
            'person' => $this->personDescription,
            'tags' => $this->tags,
        ];

        $this->render();
    }

    public function setPersons()
    {
        // Variável para verificar se a pessoa já foi adicionada, para evitar duplicações
        $personAlreadyInArray = false;

        foreach ($this->persons as $person) {
            ($person['id'] == $this->personId) ? $personAlreadyInArray = true : '';
        }

        if ($personAlreadyInArray == false) {
            array_push($this->persons, ['id' => $this->personId, 'description' => $this->personDescription]);
        }
    }

    public function removePerson($key)
    {
        unset($this->persons[$key]);
    }

    public function updatedTag()
    {
        array_push($this->tags, $this->tag);
        $this->tag = '';
    }

    public function removeTag($key)
    {
        unset($this->tags[$key]);
    }

    public function cleanFields($fields)
    {
        if (strpos($fields, ',') !== false) {
            $fields = explode(',', $fields);
        }
        $this->reset($fields);
    }
}
