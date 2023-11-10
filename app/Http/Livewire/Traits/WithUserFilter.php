<?php

namespace App\Http\Livewire\Traits;

use App\Repositories\UserRepository;
use App\Services\ArrayHandler;

trait WithUserFilter
{
    public $usersSearch;
    public $users = [];
    public $selectedUsers = [];
    public $checkAllUsers;
    public $usersPerPage = 30;
    public $usersSortBy = 'id';
    public $usersSortDirection = 'asc';
    public $showUsersFilter = true;
    public $groupReportByUser = false;

    public function usersSortBy($field)
    {
        $this->usersSortDirection == 'asc' ? $this->usersSortDirection = 'desc' : $this->usersSortDirection = 'asc';
        return $this->usersSortBy = $field;
    }

    public function updatedSelectedUsers()
    {
        $this->selectedUsers = array_filter($this->selectedUsers);
        $this->checkAllUsers = sizeof($this->selectedUsers) == sizeof($this->users) ? true : false;

        $this->showDataReport = false;
    }

    public function updatedCheckAllUsers()
    {
        if ($this->checkAllUsers == true) {
            foreach ($this->users as $item) {
                $this->selectedUsers[$item['id']] = $item['code'] . ' - ' . $item['description'];
            }
        } else {
            $this->selectedUsers = [];
        }

        $this->showDataReport = false;
    }

    public function updatedUsersSearch()
    {
        $repository = new UserRepository();

        $users = $repository->all($this->usersSearch, $this->usersSortBy, $this->usersSortDirection, $this->usersPerPage);

        $this->users = ArrayHandler::jsonDecodeEncode($users, true);
    }
}
