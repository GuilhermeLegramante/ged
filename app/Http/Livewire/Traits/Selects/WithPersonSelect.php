<?php

namespace App\Http\Livewire\Traits\Selects;

use App\Repositories\PersonRepository;
use Illuminate\Support\Facades\App;
use Str;

trait WithPersonSelect
{
    public $personId;

    public $personDescription;

    public function selectPerson($id)
    {
        $repository = App::make(PersonRepository::class);

        $data = $repository->findById($id);

        $this->personId = $data->id;

        $this->personDescription = Str::words($data->description, 5);

        array_push($this->inputs,
            [
                'field' => 'personId',
                'edit' => true,
            ]
        );

        $this->resetValidation('personId');

        $this->setPersons();
    }
}
