<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Dotaznik
 *
 * @author pes2704
 */
class Projektor2_View_HTML2PDF_Dotaznik extends Projektor2_View_HTML2PDF_Base {
    
    public function createPDFObject() {
        require("Classes/MPDF57/mpdf.php");
        $mpdf = new mPDF('utf-8','A4',8,'dejavusans'); 
        $mpdf->useOnlyCoreFonts = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetAutoFont(0);        
        $mpdf->WriteHTML(file_get_contents('./css/styles.css'),1);
        $mpdf->WriteHTML(file_get_contents('./css/form.css'),1);
        $mpdf->WriteHTML($this->context['html']);    
        
        return $mpdf;
    }
}
