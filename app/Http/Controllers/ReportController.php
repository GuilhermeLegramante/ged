<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Pdf\MpdfReport;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function productivityResume(Request $request)
    {
        // $repository = new BrandRepository();

        // $brands = $repository->allFromBook($request->all());

        // $data['brands'] = $brands;

        $data = [];

        $pdf = new MpdfReport('pdf.brands-book', 'Livro de Marcas', $data);

        return $pdf->stream();
    }

}
