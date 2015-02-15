<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Layout
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Header extends Framework_View_Abstract {
    public function render() {    
        $this->parts[] = '<div class="header">';
            $this->parts[] = '<div id="logout-ie">';
            $this->parts[] = $this->context['contextControllerResult'];
                $this->parts[] = '<div id="logout">';
                $this->parts[] = $this->context['logoutControllerResult'];
                $this->parts[] = '</div>';
            $this->parts[] = '</div>';
            $this->parts[] = $this->context['logoControllerResult'];
        $this->parts[] = '</div>';
        return $this;
    }
}
