<?php

namespace App\Http\Livewire;

use App;
use App\Http\Livewire\Traits\Selects\WithDocumentTypeSelect;
use App\Http\Livewire\Traits\WithForm;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class DocumentFormModal extends Component
{
    use WithForm, WithDocumentTypeSelect, WithFileUploads;

    public $entity;
    public $pageTitle;
    public $icon = 'fas fa-file-alt';
    public $method = 'store';
    public $formTitle;

    protected $repositoryClass = 'App\Repositories\DocumentRepository';

    public $note;
    public $tag;
    public $tags = [];
    public $file;
    public $number;
    public $date;

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
    ];

    protected $listeners = [
        'showDocumentFormModal',
        'selectDocumentType',
    ];

    protected $validationAttributes = [
        'note' => 'Descrição',
        'documentTypeId' => 'Tipo de Documento',
        'file' => 'Arquivo',
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
        $this->reset('recordId', 'note', 'file', 'number', 'date', 'tags');

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

        $this->note = $data->note;

        $this->number = $data->number;

        $this->date = $data->date;

        $this->storedFilePath = $data->path;

        $this->storedFilename = $data->filename;

        if (isset($data->documentTypeId)) {
            $this->selectDocumentType($data->documentTypeId);
        }

        if (isset($data->tags)) {
            foreach ($data->tags as $value) {
                array_push($this->tags, $value->tag);
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
}
