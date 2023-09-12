<?php

namespace App\Http\Livewire\Components;

use App\Http\Livewire\Traits\WithDatatable;
use Livewire\Component;
use Livewire\WithPagination;

abstract class TableComponent extends Component
{
    use WithDatatable, WithPagination;

    public $pageTitle;
    public $icon;
    public $searchFieldsLabel;

    /**
     * Class constructor
     * 
     * @param string $pageTitle - Title showed in the page
     * @param string $icon - Fontawesome icon class
     * @param string $searchFieldsLabel - Label of fields that will be used to search
     */
    public function mount(string $pageTitle, string $icon, string $searchFieldsLabel)
    {
        $this->pageTitle = $pageTitle;
        $this->icon = $icon;
        $this->searchFieldsLabel = $searchFieldsLabel;
    }

    public function render()
    {
        return view('livewire.components.table-component');
    }
}
