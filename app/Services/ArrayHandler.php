<?php

namespace App\Services;

class ArrayHandler
{
    public static function jsonDecodeEncode($data, $hasPagination = false)
    {
        if ($hasPagination) {
            return json_decode(json_encode($data), true)['data'];
        } else {
            return json_decode(json_encode($data), true);
        }
    }

    /**
     * Set select options
     *
     * @param $data (collection from DB)
     * @param string $value (register identifier ex. id)
     * @param string $description (register description ex. name)
     * @return array
     */
    public static function setSelect($data, string $value, string $description)
    {
        $property = [];

        foreach ($data as $key => $item) {
            $property[$key]['value'] = $item->{$value};
            $property[$key]['description'] = $item->{$description};
        }

        return $property;
    }

    /**
     * Set select options from config.domains-tables file
     *
     * @param $data (array from config file)
     * @return array
     */
    public static function setSelectFromConfig($data)
    {
        foreach ($data as $key => $item) {
            $property[$key]['value'] = $key;
            $property[$key]['description'] = $item;
        }

        return $property;
    }
}
