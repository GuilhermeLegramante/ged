<?php

namespace App\Http\Livewire\Traits;

trait SelectMultipleStatus
{
    public $statusToFilter = [];

    public function selectMultipleStatus($statusToFilter)
    {
        $this->filter['selectedStatus'] = [];
        $this->filter['statusDescriptions'] = [];

        foreach ($statusToFilter as $key => $value) {
            array_push($this->filter['statusDescriptions'], $value);
            array_push($this->filter['selectedStatus'], $key);
        }
    }
}
