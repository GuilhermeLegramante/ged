<?php

namespace App\Http\Livewire\Traits;

trait SelectMultipleDepartment
{
    public $departments;

    public function selectMultipleDepartment($departments)
    {
        $this->filter['selectedDepartments'] = [];
        $this->filter['departmentsDescriptions'] = [];

        foreach ($departments as $key => $value) {
            array_push($this->filter['departmentsDescriptions'], $value);
            array_push($this->filter['selectedDepartments'], $key);
        }
    }
}
