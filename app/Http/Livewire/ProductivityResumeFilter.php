<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Traits\WithFilter;
use App\Http\Livewire\Traits\WithReportSettings;
use App\Http\Livewire\Traits\WithUserFilter;
use App\Http\Livewire\Traits\WithVerticalPagination;
use App\Repositories\DocumentRepository;
use App\Repositories\UserRepository;
use App\Services\ArrayHandler;
use App\Services\SessionService;
use Livewire\Component;

class ProductivityResumeFilter extends Component
{
    use WithFilter, WithReportSettings, WithVerticalPagination, WithUserFilter;

    public $pageTitle = 'Registro de Produtividade';

    public $icon = 'fas fa-file-alt';

    protected $paginationTheme = 'bootstrap';

    public $initialDate = null;

    public $finalDate = null;

    public $totalDocuments = 0;

    protected $validationAttributes = [
        'finalDate' => 'Data Final',
        'initialDate' => 'Data Inicial',
    ];

    protected $messages = [
        'finalDate.after' => 'A Data Final deve ser posterior à Data Inicial.',
    ];

    public function rules()
    {
        return [
            'finalDate' => ['after:' . $this->initialDate],
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules());
    }

    public function mount()
    {
        SessionService::start();

        $this->initialDate = '1900-01-01';

        $this->finalDate = date('Y-m-d', strtotime(now()));

        $repository = new UserRepository();

        $users = $repository->all($this->usersSearch, $this->usersSortBy, $this->usersSortDirection, $this->usersPerPage);

        $this->users = ArrayHandler::jsonDecodeEncode($users, true);

        $this->hasPdfReport = false;
    }

    public function render()
    {
        return view('livewire.productivity-resume-filter');
    }

    public function report()
    {
        $filters = [];

        count($this->selectedUsers) > 0 ? $filters['users'] = array_keys($this->selectedUsers) : '';

        count($this->selectedUsers) > 0 ? $filters['usersDescription'] = $this->selectedUsers : '';

        isset($this->initialDate) ? $filters['initialDate'] = $this->initialDate : '';

        isset($this->finalDate) ? $filters['finalDate'] = $this->finalDate : '';

        return redirect()->route('report.productivity-resume', $filters);
    }

    public function viewData()
    {
        $repository = new DocumentRepository();

        $this->totalDocuments = $repository->totalDocumentsByFilter(array_keys($this->selectedUsers), $this->initialDate, $this->finalDate);
    }
}
