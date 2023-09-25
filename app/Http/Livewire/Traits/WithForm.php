<?php

namespace App\Http\Livewire\Traits;

use App\Services\ErrorHandler;
use App\Services\FormService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Str;

trait WithForm
{
    public $isEdition = false;
    public $recordId;

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules());
    }

    public function showModalDelete()
    {
        $this->emit('delete');
    }

    public function cleanFields($fields)
    {
        if (strpos($fields, ',') !== false) {
            $fields = explode(',', $fields);
        }
        $this->reset($fields);
    }

    public function store()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $this->customValidate();

            $repository = App::make($this->repositoryClass);

            $data = FormService::resolveInputs($this, $this->inputs);

            $repository->save($data);
            session()->flash('success', 'Registro salvo com sucesso');
            DB::commit();

            $this->emit('hide' . ucfirst(Str::camel($this->entity)) . 'FormModal');

            $this->emit('scrollTop');

            if ($this->refreshAfterAction) {
                return redirect()->route($this->entity . '.table');
            }
        } catch (\Exception $error) {
            DB::rollback();

            $errorMessage = ErrorHandler::resolveMySqlMessage($error);

            session()->flash('error-details', $error->getMessage());
            session()->flash('error', $errorMessage);
        }
    }

    public function update()
    {
        $this->validate();
        try {
            DB::beginTransaction();

            $this->customValidate();

            $repository = App::make($this->repositoryClass);

            $data = FormService::resolveInputs($this, $this->inputs);

            $repository->update($data);
            session()->flash('success', 'Registro editado com sucesso');
            DB::commit();

            $this->emit('hide' . ucfirst(Str::camel($this->entity)) . 'FormModal');

            $this->emit('scrollTop');

            if ($this->refreshAfterAction) {
                return redirect()->route($this->entity . '.table');
            }
        } catch (\Exception $error) {
            DB::rollback();

            $errorMessage = ErrorHandler::resolveMySqlMessage($error);

            session()->flash('error-details', $error->getMessage());
            session()->flash('error', $errorMessage);
        }
    }

    public function destroy()
    {
        try {
            DB::beginTransaction();

            $this->customDeleteValidate();

            $repository = App::make($this->repositoryClass);
            $repository->delete([
                'recordId' => $this->recordId,
            ]);
            session()->flash('success', 'Registro excluído com sucesso');
            DB::commit();

            return redirect()->route($this->entity . '.table');
        } catch (\Exception $error) {
            DB::rollback();

            $this->emit('close');

            $errorMessage = ErrorHandler::resolveMySqlMessage($error);

            session()->flash('error-details', $error->getMessage());
            session()->flash('error', $errorMessage);
        }
    }
}
