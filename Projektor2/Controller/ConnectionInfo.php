<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Hlavicka
 *
 * @author pes2704
 */
class Projektor2_Controller_ConnectionInfo extends Projektor2_Controller_Abstract {
    
    public function getResult() {
        $dbh = Projektor2_AppContext::getDb();
            if ($dbh->getDbHost() == 'localhost') {
                $html = '<DIV class="connection development">';  
            } else {
                $html = '<DIV class="connection production">';   
            }
            $html .= '            Uživatel '.$this->sessionStatus->user->username.' pracuje s databází '. 
                    $dbh->getDbName().' na stroji '.$dbh->getDbHost().' jako '.$dbh->getUser().'.';
            $html .= '     </DIV>';
        return $html;
    }
}

?>