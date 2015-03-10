<?php
/**
 * Description of Export
 *
 * @author pes2704
 */
class Projektor2_Controller_Ap_Export extends Projektor2_Controller_Abstract {
    
    public function getResult() {
        if($this->request->post('dbtabulka') AND substr($this->request->post('dbtabulka'),0,3)<>"---") {
            $tabulka = $this->request->post('dbtabulka');
            $exportExcel = new Projektor2_Controller_Export_Excel($this->sessionStatus, $this->request, $this->response, $params);
//                    ($tabulka);
            if ($exportExcel->save(NULL, 1)) {
                Projektor2_VynucenyDownload::download($exportExcel->getFullFileName());                    
            } else {
                return $exportExcel->getResult();
            }
        } else {
            $view = new Projektor2_View_HTML_Ap_Export($this->sessionStatus);
            return $view->render();
        }
    }


}

?>
