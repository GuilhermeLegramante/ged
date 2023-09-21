<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Traits\WithSelect;
use Livewire\Component;

class PersonSelect extends Component
{
    use WithSelect;

    public $title = 'Pessoa';
    public $modalId = 'modal-select-person';
    public $searchFieldsLabel = 'Código ou Descrição';

    public $closeModal = 'closePersonModal';
    public $selectModal = 'selectPerson';
    public $showModal = 'showPersonModal';

    protected $repositoryClass = 'App\Repositories\PersonRepository';

    public function render()
    {
        $this->insertButtonOnSelectModal = true;

        $this->addMethod = 'showPersonFormModal';

        $this->search();

        $data = $this->data;

        return view('livewire.person-select', compact('data'));
    }
}
