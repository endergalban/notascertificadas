<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    // Incluimos el archivo fpdf
    require_once APPPATH."third_party/pdf/fpdf.php";

    //Extendemos la clase Pdf de la clase fpdf para que herede todas sus variables y funciones
    class Pdf extends FPDF {
        public function __construct() {
            parent::__construct();
        }

       /* function Footer()
		{
			$this->SetFont('Arial','I',8);
			$this->Ln();
			$this->SetY(280);
			$this->Cell(95,5,utf8_decode("Página " . $this->PageNo() . "/{nb} - Fecha de Impresión " . strtolower(date('d/m/Y h:i:s A '))), 0, '', 'L');
			$this->Cell(95,5,'Notas Certificadas', 0, '', 'R');

		}*/

    }
?>
