<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
require_once FCPATH.'vendor/autoload.php';

use Dompdf\Dompdf as Dompdf;

class PdfGenerator
{
  public function generate($html, $filename)
  {
    $dompdf = new Dompdf();
    $dompdf->load_html($html);
    $dompdf->render();
    $dompdf->stream($filename.'.pdf',array("Attachment"=>0));
  }
}
