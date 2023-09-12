<?php

namespace App\Services;
    
use Illuminate\Support\Facades\Http;

class ViaCep
{
    public static function search($cep)
    {
        $cep = str_replace('-', '', $cep);

        $response = Http::get('https://viacep.com.br/ws/'. $cep .'//json//');

        return $response->json();
    }
}
