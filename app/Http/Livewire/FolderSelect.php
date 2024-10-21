<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Traits\WithSelect;
use Livewire\Component;

class FolderSelect extends Component
{
    use WithSelect;

    public $title = 'Pasta';
    public $modalId = 'modal-select-folder';
    public $searchFieldsLabel = 'Código ou Descrição';

    public $closeModal = 'closeFolderModal';
    public $selectModal = 'selectFolder';
    public $showModal = 'showFolderModal';

    protected $repositoryClass = 'App\Repositories\FolderRepository';

    public function render()
    {
        $this->insertButtonOnSelectModal = true;

        $this->addMethod = 'showFolderFormModal';

        $this->search();

        $data = $this->data;

        return view('livewire.folder-select', compact('data'));
    }
}
