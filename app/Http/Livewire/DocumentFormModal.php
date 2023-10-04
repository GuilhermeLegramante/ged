<?php

namespace App\Http\Livewire;

use App;
use App\Http\Livewire\Traits\Selects\WithDocumentTypeSelect;
use App\Http\Livewire\Traits\Selects\WithPersonSelect;
use App\Http\Livewire\Traits\WithForm;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class DocumentFormModal extends Component
{
    use WithForm, WithDocumentTypeSelect, WithFileUploads, WithPersonSelect;

    public $entity;
    public $pageTitle;
    public $icon = 'fas fa-file-alt';
    public $method = 'store';
    public $formTitle;

    public $refreshAfterAction = false;

    protected $repositoryClass = 'App\Repositories\DocumentRepository';

    public $note;
    public $tag;
    public $tags = [];
    public $file;
    public $number;
    public $date;
    public $persons = [];
    public $validityStart;
    public $validityEnd;

    public $storedFilePath;
    public $storedFilename;

    public $inputs = [
        [
            'field' => 'recordId',
            'edit' => true,
        ],
        [
            'field' => 'note',
            'edit' => true,
            'type' => 'string',
        ],
        [
            'field' => 'file',
            'edit' => true,
            'type' => 'file',
        ],
        [
            'field' => 'number',
            'edit' => true,
            'type' => 'string',
        ],
        [
            'field' => 'date',
            'edit' => true,
        ],
        [
            'field' => 'tags',
            'edit' => true,
        ],
        [
            'field' => 'storedFilePath',
            'edit' => true,
        ],
        [
            'field' => 'storedFilename',
            'edit' => true,
        ],
        [
            'field' => 'persons',
            'edit' => true,
        ],
        [
            'field' => 'validityStart',
            'edit' => true,
        ],
        [
            'field' => 'validityEnd',
            'edit' => true,
        ],
    ];

    protected $listeners = [
        'showDocumentFormModal',
        'selectDocumentType',
        'selectPerson',
    ];

    protected $validationAttributes = [
        'note' => 'Descrição',
        'documentTypeId' => 'Tipo de Documento',
        'file' => 'Arquivo',
        'personId' => 'Pessoa',
        'validityStart' => 'Início da Vigência',
        'validityEnd' => 'Fim da Vigência',
    ];

    public function rules()
    {
        return [
            'note' => ['required'],
            'file' => [Rule::requiredIf(!$this->isEdition)],
        ];
    }

    public function showDocumentFormModal($id = null)
    {
        $this->reset(
            'recordId',
            'note',
            'documentTypeId',
            'documentTypeDescription',
            'file',
            'number',
            'date',
            'tags',
            'persons',
            'storedFilePath',
            'storedFilename'
        );

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
        $this->formTitle = strtoupper('DADOS DO(A) Documento');
        $this->entity = 'document';
        $this->pageTitle = 'Documento';

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

        $this->note = $data->note;

        $this->number = $data->number;

        $this->date = $data->date;

        $this->storedFilePath = $data->path;

        $this->storedFilename = $data->filename;

        $this->validityStart = $data->validityStart;

        $this->validityEnd = $data->validityEnd;

        if (isset($data->documentTypeId)) {
            $this->selectDocumentType($data->documentTypeId);
        }

        if (isset($data->tags)) {
            foreach ($data->tags as $value) {
                array_push($this->tags, $value->tag);
            }
        }

        if (isset($data->persons)) {
            foreach ($data->persons as $person) {
                array_push($this->persons, ['id' => $person->id, 'description' => $person->name]);
            }
        }
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

    public function updatedTag()
    {
        array_push($this->tags, $this->tag);
        $this->tag = '';
    }

    public function removeTag($key)
    {
        unset($this->tags[$key]);
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
}
