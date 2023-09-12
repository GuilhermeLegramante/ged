<?php

namespace App\Http\Livewire\Traits;

use Illuminate\Support\Facades\App;

trait WithSelect
{
    use WithDatatable;

    public $checkAll;

    public $selected = [];

    public $type = 'single';

    private $data = [];

    public $addMethod;

    public $headerColumns = [
        ['field' => 'id', 'label' => 'Código', 'css' => 'text-center w-10'],
        ['field' => 'description', 'label' => 'Descrição', 'css' => 'w-50'],
        ['field' => null, 'label' => 'Ações', 'css' => 'w-10'],
    ];

    public $bodyColumns = [
        ['field' => 'id', 'type' => 'string', 'css' => 'text-center'],
        ['field' => 'description', 'type' => 'string', 'css' => 'pl-12px'],
    ];

    public $modalActionButtons = [
        ['view' => 'partials.buttons.select-modal'],
    ];

    public function updatedSearch()
    {
        $this->emit($this->showModal);
    }

    public function updatedSelected()
    {
        $this->selected = array_filter($this->selected);
        sizeof($this->selected) == sizeof($this->data) ? $this->checkAll = true : $this->checkAll = false;
    }

    public function updatedCheckAll()
    {
        if ($this->checkAll == true) {
            $repository = App::make($this->repositoryClass);
            $data = $repository->allSimplified();

            foreach ($data as $value) {
                $this->selected[$value->id] = $value->description;
            }

        } else {
            $this->selected = [];
        }
    }

    public function search()
    {
        $repository = App::make($this->repositoryClass);

        $this->data = $repository
            ->all($this->search, $this->sortBy, $this->sortDirection, $this->perPage);
    }

    public function select($id)
    {
        $this->emit($this->closeModal);
        $this->emit($this->selectModal, $id);
    }

    public function selectMultiple()
    {
        $this->emit($this->closeModal);
        $this->emit($this->selectModal, $this->selected);
    }
}
