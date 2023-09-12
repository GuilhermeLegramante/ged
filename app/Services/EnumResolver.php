<?php

namespace App\Services;

class EnumResolver
{
    public static function governmentBranches(string $letter) : string
    {
        switch ($letter) {
            case 'L':
                return 'LEGISLATIVO';

            case 'E':
                return 'EXECUTIVO';

            case 'J':
                return 'JUDICIÁRIO';

            default:
                return 'EXECUTIVO';
        }
    }

    public static function governmentSpheres(string $letter) : string
    {
        switch ($letter) {
            case 'F':
                return 'FEDERAL';

            case 'E':
                return 'ESTADUAL';

            case 'M':
                return 'MUNICIPAL';

            case 'D':
                return 'DISTRITAL';

            default:
                return 'MUNICIPAL';
        }
    }
}
