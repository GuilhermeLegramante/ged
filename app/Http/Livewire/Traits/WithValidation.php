<?php

namespace App\Http\Livewire\Traits;

trait WithValidation
{
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules());
    }
}
