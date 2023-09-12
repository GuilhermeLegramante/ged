<?php

namespace Tests\Unit;

use App\Services\ArrayHandler;
use App\Services\PncpClient;
use Tests\TestCase;

class InsertContractTest extends TestCase
{

    /**
     * A basic unit test example.
     *
     * @test
     * @return void
     */
    public function payload_test()
    {
        $url = config('pncp-api.endpoints.organs') . '/' . config('pncp-api.cnpj') . '/contratos';

        $client = new PncpClient();

        $payload = '{
            "cnpjCompra": "10000000000003",
            "anoCompra": 2021,
            "sequencialCompra": 1,
            "tipoContratoId": 1,
            "numeroContratoEmpenho": "1",
            "anoContrato": 2021,
            "processo": "1/2021",
            "categoriaProcessoId": 2,
            "receita": false,
            "codigoUnidade": "1",
            "niFornecedor": "10000000000010",
            "tipoPessoaFornecedor": "PJ",
            "nomeRazaoSocialFornecedor": "Fornecedor do Teste I",
            "niFornecedorSubContratado": "",
            "tipoPessoaFornecedorSubContratado": "",
            "nomeRazaoSocialFornecedorSubContratado": "",
            "objetoContrato": "Contrato para exemplificar uso da API PNCP.",
            "informacaoComplementar": "",
            "valorInicial": 10000.0000,
            "numeroParcelas": 2,
            "valorParcela": 5000.0000,
            "valorGlobal": 10000.0000,
            "valorAcumulado": 10000.0000,
            "dataAssinatura": "2021-07-27",
            "dataVigenciaInicio": "2021-07-28",
            "dataVigenciaFim": "2021-07-29",
            "identificadorCipi": "111.11-011",
            "urlCipi": " https://cipi.economia.gov.br/111.11-011"
           }';

        dd(ArrayHandler::jsonDecodeEncode($payload));


        $response = $client->post($url, ArrayHandler::jsonDecodeEncode($payload));

        $this->assertTrue(isset($response));
    }
}
