<?php
class Projektor2_Controller_Export_Excel extends Projektor2_Controller_Abstract {

    public function getResult() {
        if($this->request->post('dbtabulka') AND substr($this->request->post('dbtabulka'),0,3)<>"---") {
            $tabulka = $this->request->post('dbtabulka');
            $modelExcel = Projektor2_Model_File_ExcelMapper::create($tabulka);
            if (Projektor2_Model_File_ExcelMapper::save($modelExcel, $this->sessionStatus)) {
                $downloadController = new Projektor2_Controller_ForcedDownload();
                // Projektor2_Controller_ForcedDownload->download končí příkazem exit, ukončí běh skriptu
                $downloadController->download($modelExcel->documentFileName);                    
            } else {
                $parts[] = new Projektor2_View_HTML_ExportExcel($this->sessionStatus);
            }
        } else {
            switch ($this->sessionStatus->projekt->kod) {
                case 'HELP':
                    $parts[] = new Projektor2_View_HTML_Help_Export($this->sessionStatus);
                    break;
                case 'AP':
                    $parts[] = new Projektor2_View_HTML_Ap_Export($this->sessionStatus);
                    break;
                case 'SJZP':
                    $parts[] = new Projektor2_View_HTML_Sjzp_Export($this->sessionStatus);
                    break;
                default:
                    break;
            }
            $view = new Projektor2_View_HTML_Element_Div($this->sessionStatus, array('htmlParts'=>$parts));
            return $view;
        }
    }
}

