<?php

namespace App\Services;

use App\Services\Mask;

class FormService
{

    /**
     * Resolve livewire component variables to WithForm trait methods (store and update)
     *
     * @param [Livewire Component] $component
     * @param [Livewire Component inputs] $inputs (this variable is protected, for this, we pass it's here)
     *
     * @return array $data
     */
    public static function resolveInputs($component, $inputs)
    {
        $data = [];

        $array = json_decode(json_encode($component), true);

        foreach ($inputs as $value) {
            if (isset($value['type'])) {
                if ($value['type'] == 'monetary') {
                    $data[$value['field']] = Mask::removeMoneyMask($array[$value['field']]);
                }
                if ($value['type'] == 'string') {
                    $data[$value['field']] = Mask::normalizeString($array[$value['field']]);
                }
                if ($value['type'] == 'number') {
                    $data[$value['field']] = $array[$value['field']];
                }
                if ($value['type'] == 'file') {
                    $data[$value['field']] = $component->{$value['field']};
                }
            } else {
                $data[$value['field']] = $array[$value['field']];
            }
        }

        return $data;
    }

}
