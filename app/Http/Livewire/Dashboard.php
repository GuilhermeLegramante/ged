<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class Dashboard extends Component
{
    use WithFileUploads;

    public $pageTitle = 'Demandas';
    public $icon = 'fas fa-list';

    public $filterStartDate;
    public $filterFinalDate;
    public $filterStatus;
    public $filterText;
    public $filterClientId;

    public $title;
    public $subtitle;
    public $description;
    public $clientId;
    public $publicationDate;
    public $demandTypeId;
    public $demandStatusId;
    public $files;
    public $statusColor = '#2d6a2d';

    public $isEdition = false;

    public function mount()
    {
    }

    public function showForm($demandId = null)
    {
        if (isset($demandId)) {
            $this->setFields();
        } else {
            $this->resetFields();
        }

        $this->emit('showDemandFormModal');
    }

    private function setFields()
    {
        $this->isEdition = true;

        $this->title = 'Título do Post';

        $this->subtitle = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum convallis elit non elit iaculis';

        $this->description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum convallis elit non elit iaculis, ac egestas tortor malesuada. Suspendisse id augue feugiat, tristique sem non, euismod risus. Vestibulum convallis elit non elit iaculis, ac egestas tortor malesuada. Suspendisse id augue feugiat, tristique sem non, euismod risus';

        $this->clientId = 1;

        $this->publicationDate = '2022-05-02 10:00:00';

        $this->demandTypeId = 1;

        $this->demandStatusId = 1;
    }

    private function resetFields()
    {
        $this->reset([
            'isEdition', 'title', 'subtitle', 'description',
            'clientId', 'publicationDate', 'demandTypeId', 'demandStatusId'
        ]);
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
