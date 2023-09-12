<?php

namespace App\Services;

class Mask
{
    // $cnpj = '11222333000199';
    // $cpf = '00100200300';
    // $cep = '08665110';
    // $data = '10102010';
    // $hora = '021050';

    // $this->genericMask($cnpj, '##.###.###/####-##').'<br>';
    // $this->genericMask($cpf, '###.###.###-##').'<br>';
    // $this->genericMask($cep, '#####-###').'<br>';
    // $this->genericMask($data, '##/##/####').'<br>';
    // $this->genericMask($data, '##/##/####').'<br>';
    // $this->genericMask($data, '[##][##][####]').'<br>';
    // $this->genericMask($data, '(##)(##)(####)').'<br>';
    // $this->genericMask($hora, 'Agora são ## horas ## minutos e ## segundos').'<br>';
    // $this->genericMask($hora, '##:##:##');

    private function genericMask($val, $mask)
    {
        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; ++$i) {
            if ($mask[$i] == '#') {
                if (isset($val[$k])) {
                    $maskared .= $val[$k++];
                }
            } else {
                if (isset($mask[$i])) {
                    $maskared .= $mask[$i];
                }
            }
        }

        return $maskared;
    }

    public static function telefone($value)
    {
        $mask = new Mask();
        if ((strlen($value) == 11) && (is_numeric($value))) {
            return $mask->genericMask($value, '(##)#####-####');
        } else if ((strlen($value) == 10) && (is_numeric($value))) {
            return $mask->genericMask($value, '(##)####-####');
        } else {
            return $value;
        }
    }

    public static function phone($value)
    {
        $mask = new Mask();
        if ((strlen($value) == 11) && (is_numeric($value))) {
            return $mask->genericMask($value, '(##)#####-####');
        } else if ((strlen($value) == 10) && (is_numeric($value))) {
            return $mask->genericMask($value, '(##)####-####');
        } else {
            return $value;
        }
    }

    public static function cpfCnpj($value)
    {
        if ((strlen($value) == 11) && (is_numeric($value))) {
            $value = substr($value, 0, 3) . '.' . substr($value, 3, 3) . '.' . substr($value, 6, 3) . '-' . substr($value, 9);
        }

        if ((strlen($value) == 14) && (is_numeric($value))) {
            $value = substr($value, 0, 2) . '.' . substr($value, 2, 3) . '.' . substr($value, 5, 3) . '/' . substr($value, 8, 4) . '-' . substr($value, 12, 2);
        }

        return $value;
    }

    public static function removeCpfCnpj($value)
    {
        return preg_replace('/[^0-9]/', '', $value);
    }

    public static function cpfCnpjPartial($value)
    {
        $mask = new Mask();
        $value = preg_replace('/[^0-9]/', '', $value);

        if (strlen($value) > 3 && strlen($value) <= 6) {
            return $mask->genericMask($value, '###.###');
        } else if (strlen($value) > 6 && strlen($value) <= 9) {
            return $mask->genericMask($value, '###.###.###');
        } else if (strlen($value) > 9 && strlen($value) <= 11) {
            return $mask->genericMask($value, '###.###.###-##');
        } else if (strlen($value) > 11 && strlen($value) <= 12) {
            return $mask->genericMask($value, '##.###.###/####');
        } else if (strlen($value) > 12 && strlen($value) <= 14) {
            return $mask->genericMask($value, '##.###.###/####-##');
        }

        return $value;
    }

    public static function money($value)
    {
        if (is_numeric($value)) {
            $value = number_format($value, 2, ',', '.');
        } else {
            $value = preg_replace("/[^0-9,]/", "", $value);
            $value = preg_replace("/,/", ".", $value);
            if (is_numeric($value)) {
                $value = number_format($value, 2, ',', '.');
            }
        }

        return $value;
    }

    public static function cep($value)
    {
        $mask = new Mask();
        return $mask->genericMask($value, '#####-###');
    }

    public static function removeMoneyMask($value, $decimals = 2)
    {
        // Remove todos os caracteres não numéricos e diferentes de . e ,
        $newValue = preg_replace("/[^0-9.,]/", "", $value);

        if(isset($value)){
            return number_format(str_replace(",", ".", str_replace(".", "", $newValue)), $decimals, '.', '');
        } else {
            return 0;
        }
    }

    public static function positiveMoneyValue($value)
    {
        $newValue = Mask::removeMoneyMask($value);
        return Mask::money($newValue);
    }

    public static function codUnidade($value)
    {
        if ((strlen($value) == 5) && (is_numeric($value))) {
            $value = substr($value, 0, 2) . '.' . substr($value, 2, 3);
        } else {
            $value = preg_replace('/[^0-9]/', "", $value);
        }

        return $value;
    }

    public static function expenseNature($value)
    {
        //Retira todos os caracteres não númericos
        $value = preg_replace('/[^0-9]/', "", $value);

        //Insere os 0s que faltarem
        $value = str_pad($value, 14, "0", STR_PAD_RIGHT);

        //Aplica a máscara no formato 0.0.00.00.00.00.00.00
        return substr($value, 0, 1) . '.' . substr($value, 1, 1) . '.' . substr($value, 2, 2) .
        '.' . substr($value, 4, 2) . '.' . substr($value, 6, 2) . '.' . substr($value, 8, 2) .
        '.' . substr($value, 10, 2) . '.' . substr($value, 12, 2);
    }

    public static function ledgerAccount($value)
    {
        //Retira todos os caracteres não númericos
        $value = preg_replace('/[^0-9]/', "", $value);

        //Insere os 0s que faltarem
        $value = str_pad($value, 15, "0", STR_PAD_RIGHT);

        //Aplica a máscara no formato 0.0.0.0.0.00.00.00.00.00
        return substr($value, 0, 1) . '.' . substr($value, 1, 1) . '.' . substr($value, 2, 1) .
        '.' . substr($value, 3, 1) . '.' . substr($value, 4, 1) . '.' . substr($value, 5, 2) .
        '.' . substr($value, 7, 2) . '.' . substr($value, 9, 2) . '.' .substr($value, 11, 2) . '.' .substr($value, 13, 2);
    }

    public static function getExpenseNatureAtLevel($value, $level)
    {
        switch ($level) {
            case 1:
                return substr($value, 0, 2);
                break;

            case 2:
                return substr($value, 0, 4);
                break;

            case 3:
                return substr($value, 0, 7);
                break;

            case 4:
                return substr($value, 0, 10);
                break;

            case 5:
                return substr($value, 0, 13);
                break;

            case 6:
                return substr($value, 0, 16);
                break;

            case 7:
                return substr($value, 0, 19);
                break;

            case 8:
                return substr($value, 0, 21);
                break;

        }
    }

    public static function revenueNature($value)
    {
        //Retira todos os caracteres não númericos
        $value = preg_replace('/[^0-9]/', "", $value);

        //Insere os 0s que faltarem
        $value = str_pad($value, 14, "0", STR_PAD_RIGHT);

        //Aplica a máscara no formato 0.0.0.0.00.0.0.00.00.00
        return substr($value, 0, 1) . '.' . substr($value, 1, 1) . '.' . substr($value, 2, 1) .
        '.' . substr($value, 3, 1) . '.' . substr($value, 4, 2) . '.' . substr($value, 6, 1) .
        '.' . substr($value, 7, 1) . '.' . substr($value, 8, 2) . '.' . substr($value, 10, 2) .
        '.' . substr($value, 12, 2);
    }

    public static function getRevenueNatureAtLevel($value, $level)
    {
        switch ($level) {
            case 1:
                return substr($value, 0, 2);
                break;

            case 2:
                return substr($value, 0, 4);
                break;

            case 3:
                return substr($value, 0, 6);
                break;

            case 4:
                return substr($value, 0, 8);
                break;

            case 5:
                return substr($value, 0, 11);
                break;

            case 6:
                return substr($value, 0, 13);
                break;

            case 7:
                return substr($value, 0, 15);
                break;

            case 8:
                return substr($value, 0, 18);
                break;

            case 9:
                return substr($value, 0, 21);
                break;

            case 10:
                return substr($value, 0, 23);
                break;

        }
    }

    public static function contaContabil($value)
    {
        //Retira todos os caracteres não númericos
        $value = preg_replace('/[^0-9]/', "", $value);

        //Insere os 0s que faltarem
        $value = str_pad($value, 15, "0", STR_PAD_RIGHT);

        //Aplica a máscara no formato 0.0.0.0.0.00.00.00.00.00
        return substr($value, 0, 1) . '.' . substr($value, 1, 1) . '.' . substr($value, 2, 1) .
        '.' . substr($value, 3, 1) . '.' . substr($value, 4, 1) . '.' . substr($value, 5, 2) .
        '.' . substr($value, 7, 2) . '.' . substr($value, 9, 2) . '.' . substr($value, 11, 2) .
        '.' . substr($value, 13, 2);
    }

    public static function getContaContabilAtLevel($value, $level)
    {
        switch ($level) {
            case 1:
                return substr($value, 0, 2);
                break;

            case 2:
                return substr($value, 0, 4);
                break;

            case 3:
                return substr($value, 0, 6);
                break;

            case 4:
                return substr($value, 0, 8);
                break;

            case 5:
                return substr($value, 0, 10);
                break;

            case 6:
                return substr($value, 0, 13);
                break;

            case 7:
                return substr($value, 0, 16);
                break;

            case 8:
                return substr($value, 0, 19);
                break;

            case 9:
                return substr($value, 0, 22);
                break;

            case 10:
                return substr($value, 0, 24);
                break;

        }
    }

    public static function normalizeString($value, bool $toUpper = true)
    {
        $temp = trim($value);
        if ($toUpper) {
            $temp = mb_strtoupper($temp, 'UTF-8');
        }

        return $temp;
    }
}
