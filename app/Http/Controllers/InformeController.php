<?php

namespace App\Http\Controllers; // Asegúrate de que esta línea sea así

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;

class InformeController extends Controller
{
    public function descargarPDF()
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        // Aquí cargamos la vista del inventario
        $html = view('Informes.inventario')->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream("inventario.pdf", ["Attachment" => false]);
    }
}