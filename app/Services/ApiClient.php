<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiClient
{
    public static function setToken()
    {
        if (env('HOST_TYPE') == 'shared') {
            $url = env('API_URL') . '/auth';
        } else {
            $url = env('APP_HOST_MARCAS') . '/web/api/public/auth';
        }

        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->post($url, [
            'username' => 'HARDSOFT',
            'password' => 'hsoft',
            'device' => 'guilherme-pc',
        ]);

        if ($response->status() == 200) {
            $token = $response->json()['token'];
            session()->put('token', $token);
        } else {
            $token = null;
        }

        return $token;
    }

    public static function similarityVerification($url, $token)
    {
        if (env('HOST_TYPE') == 'shared') {
            $hostUrl = env('API_URL') . '/marca/verificacao-de-similaridade';
        } else {
            $hostUrl = env('APP_HOST_MARCAS') . '/web/api/public/marca/verificacao-de-similaridade';
        }

        return Http::withHeaders([
                'Accept' => 'application/json',
            ])->withToken($token)->post($hostUrl, [
                'url' => $url,
                'filter' => 'default',
            ]);
    }

    public static function similarityVerificationWithAspects($url, $token, $aspects)
    {
        if (env('HOST_TYPE') == 'shared') {
            $hostUrl = env('API_URL') . '/marca/verificacao-de-similaridade';
        } else {
            $hostUrl = env('APP_HOST_MARCAS') . '/web/api/public/marca/verificacao-de-similaridade';
        }

        return Http::withHeaders([
                'Accept' => 'application/json',
            ])->withToken($token)->post($hostUrl, [
                'url' => $url,
                'filter' => 'aspects',
                'aspects' => $aspects,
            ]);
    }

    public static function similarityVerificationWithSubaspects($url, $token, $subaspects)
    {
        if (env('HOST_TYPE') == 'shared') {
            $hostUrl = env('API_URL') . '/marca/verificacao-de-similaridade';
        } else {
            $hostUrl = env('APP_HOST_MARCAS') . '/web/api/public/marca/verificacao-de-similaridade';
        }

        return Http::withHeaders([
                'Accept' => 'application/json',
            ])->withToken($token)->post($hostUrl, [
                'url' => $url,
                'filter' => 'subaspects',
                'subaspects' => $subaspects,
            ]);
    }
}
