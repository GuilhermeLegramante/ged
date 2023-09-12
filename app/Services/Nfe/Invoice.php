<?php

namespace App\Services\Nfe;

class Invoice {
    private $xmlObj;
    private $jsonNfe;

    public $identify;
    public $products;
    public $issuer;
    public $payment;

    private function setIdentify(object $ide, string $id) : object {
        $obj = [
            'id' => $id,
            'uf' => $ide->cUF,
            'description' => $ide->natOp,
            'model' => $ide->mod,
            'serial' => $ide->serie,
            'number' => $ide->nNF,
            'dateTime' => substr(str_replace('T', ' ', $ide->dhEmi), 0, 19),
            'operation' => $ide->tpNF,
            'city' => $ide->cMunFG,
            'type' => $ide->tpEmis,
            'finality' => $ide->finNFe
        ];

        return (object) $obj;
    }

    private function setIssuer(object $emit) : object {
        $addr = (object) $emit->enderEmit;

        $obj = [
            'cnpj' => $emit->CNPJ,
            'ie' => $emit->IE,
            'crt' => isset($emit->CRT) ? $emit->CRT : null,
            'name' => $emit->xNome,
            'corpName' => $emit->xFant,
            'address' => (object) [
                'street' => $addr->xLgr,
                'number' => $addr->nro,
                'district' => $addr->xBairro,
                'postalCode' => $addr->CEP,
                'city' => $addr->xMun,
                'country' => (object) [
                    'code' => $addr->cPais,
                    'name' => $addr->xPais
                ]
            ]
        ];

        return (object) $obj;
    }

    private function setProducts(array $items) : array {
        $prods = [];

        foreach ($items as $item) {
            $obj = (object) $item['prod'];

            $prod = [
                'code' => $obj->cProd,
                'barCode' => $obj->cEAN,
                'description' => $obj->xProd,
                'ncm' => $obj->NCM,
                'cest' => isset($obj->CEST) ? $obj->CEST : null,
                'cfop' => $obj->CFOP,
                'manufacture' => isset($obj->CNPJFab) ? $obj->CNPJFab : null,
                'measurement' => $obj->uCom,
                'amount' => $obj->qCom,
                'unitaryValue' => $obj->vUnCom,
                'totalValue' => $obj->vProd,
                'makeTotalValue' => $obj->indTot
            ];

            $prods[] = (object) $prod;
        }

        return $prods;
    }

    private function setPayment(object $pay) {
        $obj = [
            'mode' => $pay->indPag,
            'type' => $pay->tPag,
            'value' => $pay->vPag
        ];
        
        return (object) $obj;
    }
  
    public function __construct(string $xml) {
        
        // Salvar o xml original da NF-e
        $this->xmlObj = simplexml_load_string($xml);

        // Tratar os dados da NF-e para transformar em json
        $json = json_encode($this->xmlObj);
        $this->jsonNfe = json_decode($json, true);

        $this->identify = $this->setIdentify((object) $this->jsonNfe['NFe']['infNFe']['ide'], $this->jsonNfe['NFe']['infNFe']['@attributes']['Id']);
        $this->issuer = $this->setIssuer((object) $this->jsonNfe['NFe']['infNFe']['emit']);
        $this->products = $this->setProducts($this->jsonNfe['NFe']['infNFe']['det']);
        $this->payment = $this->setPayment((object) $this->jsonNfe['NFe']['infNFe']['pag']['detPag']);
    }
}