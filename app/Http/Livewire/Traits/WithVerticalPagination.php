<?php

namespace App\Http\Livewire\Traits;

trait WithVerticalPagination
{
    public function increaseOrDecreasePagination($value, $property, $method)
    {
        if ($this->{$property} >= 10) {
            $this->{$property} += $value;

            $this->{$property} == 0 ? $this->{$property} = 30 : '';

            $this->{$property} >= 0 ? $this->{$property} = $this->{$property} : $this->{$property} = 30;
        }

        $this->{$method}();
    }

}
