<?php

namespace App\Services;

use App\Repositories\ClientRepository;
use App\Repositories\ReportRepository;
use App\Repositories\UserRepository;
use App\Services\Reports\RevenuesAndExpensesByCategory;
use App\Services\SessionService;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Support\Facades\Storage;

class ReportService
{
    public function generate($params)
    {
        SessionService::start();

        $repository = new ClientRepository();
        $client = $repository->findById($params['client']);

        if (!array_key_exists('issuer', $params)) {
            $params['issuer'] = $_SESSION['username'];
        }

        $params['issue'] = date('d/m/Y \à\s H:i');
        $params['client'] = $client;

        $pdf = SnappyPdf::loadView($params['viewName'], $params);

        $pdf->setOptions([
            'header-html' => view(
                $params['header'],
                [
                    'title' => $params['title'],
                    'client' => $params['client'],
                    'issuer' => $params['issuer'],
                    'issue' => $params['issue'],
                    'period' => array_key_exists('period', $params) ? $params['period'] : '',
                    'managementUnitDescription' => array_key_exists('managementUnitDescription', $params) ? $params['managementUnitDescription'] : '',
                    'inventoryType' => array_key_exists('inventoryType', $params) ? $params['inventoryType'] : '',
                ]
            ),
            'footer-right' => 'Página [page] de [topage]',
            'footer-font-size' => '6',
            'footer-html' => view(
                'includes.report.footer',
                ['client' => $params['client']]
            ),
            'margin-left' => array_key_exists('marginLeft', $params) ? $params['marginLeft'] : 10,
            'margin-right' => array_key_exists('marginRight', $params) ? $params['marginRight'] : 10,
            'header-spacing' => array_key_exists('headerSpacing', $params) ? $params['headerSpacing'] : 0,
        ]);

        return $pdf->setPaper('a4')->stream($params['fileName'] . '.pdf');
    }

    public function save(
        $params,
        $reportId
    ) {
        SessionService::start();

        $repository = new ClientRepository;
        $client = $repository->findById($params['client']);

        if (!array_key_exists('issuer', $params)) {
            $params['issuer'] = $params['username'];
        }

        $params['issue'] = date('d/m/Y \à\s H:i');
        $params['client'] = $client;

        $pdf = SnappyPdf::loadView($params['viewName'], $params);

        $pdf->setOptions([
            'header-html' => view(
                $params['header'],
                [
                    'title' => $params['title'],
                    'client' => $params['client'],
                    'issuer' => $params['issuer'],
                    'issue' => $params['issue'],
                    'period' => array_key_exists('period', $params) ? $params['period'] : '',
                    'managementUnitDescription' => array_key_exists('managementUnitDescription', $params) ? $params['managementUnitDescription'] : '',
                    'inventoryType' => array_key_exists('inventoryType', $params) ? $params['inventoryType'] : '',
                    'monthOfAnalysis' => array_key_exists('monthOfAnalysis', $params) ? $params['monthOfAnalysis'] : '',
                    'year' => array_key_exists('year', $params) ? $params['year'] : '',
                    'reference' => array_key_exists('reference', $params) ? $params['reference'] : '',
                ]
            ),
            'footer-right' => 'Página [page] de [topage]',
            'footer-font-size' => '6',
            'orientation' => array_key_exists('orientation', $params) ? $params['orientation'] : 'Portrait',
            'footer-html' => view(
                'includes.report.footer',
                ['client' => $params['client']]
            ),
            'margin-left' => array_key_exists('marginLeft', $params) ? $params['marginLeft'] : 10,
            'margin-right' => array_key_exists('marginRight', $params) ? $params['marginRight'] : 10,
            'header-spacing' => array_key_exists('headerSpacing', $params) ? $params['headerSpacing'] : 0,
        ]);

        $path = 'C:\xampp\htdocs\web\marcas\storage\app\public\\' . $params['fileName'] . '-' . $reportId . '.pdf';

        $pdf->setPaper('a4')->save($path);

        $remotePath = 'marcas/relatorios/' . $params['fileName'] . '-' . $reportId . '.pdf';

        Storage::disk('s3')->put(
            $remotePath,
            file_get_contents($path)
        );

        unlink($path);

        return $remotePath;
    }

}
