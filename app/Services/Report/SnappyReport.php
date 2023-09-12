<?php

namespace App\Services\Report;

use App\Services\SessionService;
use App\Repositories\ClientRepository;
use Barryvdh\Snappy\Facades\SnappyPdf;

class SnappyReport {

    private $options = [];

    private $headerOptions = [];

    private $params = [];

    public $data;

    public $title;

    public $view;

    public function __construct()
    {
        SessionService::start();

        $repository = new ClientRepository();

        $client = $repository->findById(1);

        $this->options = [
            'footer-right' => '[page] de [topage]',
            'footer-font-size' => '6',
            'orientation' => 'Portrait',
            'footer-html' => view(
                'report.footer',
                ['client' => $client]
            ),
            'margin-left' => 10,
            'margin-right' => 10,
            'header-spacing' => 0,
        ];

        $this->headerOptions = [
            'client' => $client,
            'username' => session()->get('username'),
        ];

        $this->params = [
            'header' => 'includes.report.header-report',
            'marginLeft' => 4,
            'marginRight' => 4,
            'headerSpacing' => 5,
        ];
    }

    public function stream()
    {
        $this->params['viewName'] = $this->view;

        $this->params['title'] = $this->title;

        $this->params['data'] = $this->data;

        $this->headerOptions['title'] = $this->params['title'];

        $this->options['header-html'] = view(
            'report.header',
            $this->headerOptions
        );

        $repository = new ClientRepository();

        $client = $repository->findById(1);

        $this->params['client'] = $client;

        $pdf = SnappyPdf::loadView($this->params['viewName'], $this->params);

        $pdf->setOptions($this->options);

        return $pdf->setPaper('a4')->stream($this->params['title'] . '.pdf');
    }
}
