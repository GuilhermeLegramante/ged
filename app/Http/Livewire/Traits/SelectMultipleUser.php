<?php

namespace App\Http\Livewire\Traits;

trait SelectMultipleUser
{
    public $users;

    public function selectMultipleUser($users)
    {
        $this->filter['selectedUsers'] = [];
        $this->filter['usersDescriptions'] = [];

        foreach ($users as $key => $value) {
            array_push($this->filter['usersDescriptions'], $value);
            array_push($this->filter['selectedUsers'], $key);
        }
    }
}
