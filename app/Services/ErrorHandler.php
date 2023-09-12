<?php

namespace App\Services;

use Exception;

class ErrorHandler
{
    /**
     * Handle with response return from PNCP Api
     *
     * @param [type] $response
     * @return void
     */
    public static function resolveStatusCode($response): array
    {
        switch ($response->status()) {
            case 200:
                if ($response->json() != null) {
                    return $response->json();
                } else {
                    return [];
                }
            case 201:
                if ($response->json() != null) {
                    return $response->json();
                } else {
                    return [];
                }
            case 400:
                if (isset($response->json()["erros"])) {
                    foreach ($response->json()["erros"] as $error) {
                        $textErrors = $error['mensagem'] . ' <br> • &nbsp  <small>' . $error['nomeCampo'] . '</small><br><br>';
                    }
                    throw new Exception($textErrors);
                } else if (isset($response->json()['message'])) {
                    throw new Exception($response->json()['message']);
                } else {
                    throw new Exception('400: Registro não encontrado.');
                }
            case 401:
                if (isset($response->json()['message'])) {
                    throw new Exception($response->json()['message']);
                } else {
                    throw new Exception('401: Acesso não autorizado.');
                }
            case 415:
                if (isset($response->json()['message'])) {
                    throw new Exception($response->json()['message']);
                } else {
                    throw new Exception('415: Tipo de mídia não suportado.');
                }
            case 422:
                if (isset($response->json()['message'])) {
                    throw new Exception($response->json()['message']);
                } else {
                    throw new Exception('422: Entrada não processada.');
                }
            case 404:
                if (isset($response->json()['message'])) {
                    throw new Exception($response->json()['message']);
                } else {
                    throw new Exception('404: Registro não encontrado.');
                }
            case 405:
                throw new Exception('405: Método não permitido.');
            case 500:
                if (isset($response->json()['message'])) {
                    throw new Exception($response->json()['message']);
                } else {
                    throw new Exception('500: Erro no servidor.');
                }
        }

        return [];
    }

    public static function resolveMySqlMessage($error)
    {
        if (isset($error->errorInfo) && $error->errorInfo[0] == '23000') {
            return config('messages.mysql.' . $error->errorInfo[1]);
        } else {
            return $error->getMessage();
        }
    }
}
