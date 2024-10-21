<?php

namespace App\Http\Livewire\Traits\Selects;

use App\Repositories\FolderRepository;
use Illuminate\Support\Facades\App;
use Str;

trait WithFolderSelect
{
    public $folderId;

    public $folderDescription;

    public function selectFolder($id)
    {
        $repository = App::make(FolderRepository::class);

        $data = $repository->findById($id);

        $this->folderId = $data->id;

        $this->folderDescription = Str::words($data->description, 5);

        array_push(
            $this->inputs,
            [
                'field' => 'folderId',
                'edit' => true,
            ]
        );

        $this->resetValidation('folderId');
    }
}
