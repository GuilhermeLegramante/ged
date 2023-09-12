<?php

namespace App\Services\Pdf;

use App\Services\SessionService;
use App\Repositories\ClientRepository;
use App\Services\DateService;
use PDF;
use Str;

class MpdfReport {

    private $data = [];

    private $view;

    private $config = [];

    private $title;

    public function __construct(String $view, String $title, array $data, array $config = null)
    {
        SessionService::start();

        // Aumentando os limites de tempo e tamanho do mpdf
        ini_set('max_execution_time', '300');
        ini_set("pcre.backtrack_limit", "50000000");

        $repository = new ClientRepository();

        $client = $repository->findById(1);

        $this->data = $data;

        $this->data['client'] = $client;

        $this->data['title'] = $title;

        $this->config = $config;

        $this->config['format'] = 'A4';
        $this->config['default_font'] = 'sans-serif';
        $this->config['default_font_size'] = '8';
        $this->config['margin_top'] = 100;

        $this->view = $view;

        $this->title = $title;

        $this->data['currentDayToExtense'] = DateService::getCurrentDayToExtense();

    }

    public function stream()
    {
        $pdf = PDF::loadView($this->view, $this->data, [], $this->config);

        return $pdf->stream($this->title . '.pdf');
    }

    /**
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }
}
