<?php

namespace App\Http\Livewire\Traits;

use App\Services\ErrorHandler;
use App\Services\Mask;
use DB;
use Illuminate\Support\Facades\App;

trait WithDatatable
{
    public $sortBy = 'id';
    public $sortDirection = 'asc';
    protected $paginationTheme = 'bootstrap';
    public $perPage = 30;
    public $search;
    public $hasForm = true;
    public $insertButtonOnSelectModal = false;

    public $fieldIdInEdition;
    public $columnNameInEdition;
    public $valueInEdition;

    public function sortBy($field)
    {
        $this->sortDirection == 'asc' ? $this->sortDirection = 'desc' : $this->sortDirection = 'asc';
        return $this->sortBy = $field;
    }

    public function resetFields()
    {
        $this->perPage = 30;
    }

    public function resetFieldsDynamicly($fields)
    {
        $this->reset($fields);
        $this->perPage = 30;
    }

    public function load($value)
    {
        if ($this->perPage >= 10) {
            $this->perPage += $value;

            $this->perPage == 0 ? $this->perPage = 30 : '';

            $this->perPage >= 0 ? $this->perPage = $this->perPage : $this->perPage = 30;
        }
    }

    public function showForm($id = null)
    {
        if ($this->formType == 'modal') {
            if (isset($id)) {
                $this->emit($this->formModalEmitMethod, $id);
            } else {
                $this->emit($this->formModalEmitMethod);
            }

        } else {
            if (isset($id)) {
                return redirect()->route($this->entity . '.edit', ['id' => $id]);
            } else {

                return redirect()->route($this->entity . '.create');
            }
        }
    }

    // Isso resolve o bug da busca em páginas > 1
    public function updatingSearch(): void
    {
        // Caso seja modal não há os links da paginação, por isso é necessário este teste
        // para evitar o erro "livewire gotopage doesnot exists"
        if (!isset($this->modalId)) {
            $this->gotoPage(1);
        }
    }

    public function enableFieldEdition($id, $columnName, $value)
    {
        $this->fieldIdInEdition = $id;
        $this->columnNameInEdition = $columnName;
        $this->valueInEdition = $value;
    }

    public function updatedValueInEdition()
    {
        $repository = App::make($this->repositoryClass);

        try {
            DB::beginTransaction();

            $repository = App::make($this->repositoryClass);

            $data = [
                'recordId' => $this->fieldIdInEdition,
                'columnName' => $this->columnNameInEdition,
                'columnValue' => Mask::normalizeString($this->valueInEdition),
            ];

            $repository->updateSingleColumn($data);

            session()->flash('success', 'Registro editado com sucesso');

            DB::commit();

            $this->reset('fieldIdInEdition', 'columnNameInEdition');
        } catch (\Exception $error) {
            DB::rollback();

            $errorMessage = ErrorHandler::resolveMySqlMessage($error);

            session()->flash('error-details', $error->getMessage());
            session()->flash('error', $errorMessage);

            $this->reset('fieldIdInEdition', 'columnNameInEdition');
        }
    }

    public function showHideColumn($column)
    {
        foreach ($this->headerColumns as $key => $value) {
            if (isset($value['field']) && $value['field'] == $column) {
                $this->headerColumns[$key]['visible'] = !$value['visible'];
            }
        }

        foreach ($this->bodyColumns as $key => $value) {
            if (isset($value['field']) && $value['field'] == $column) {
                $this->bodyColumns[$key]['visible'] = !$value['visible'];
            }
        }
    }
}
