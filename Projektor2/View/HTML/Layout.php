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
class Projektor2_View_HTML_Layout extends Framework_View_Abstract {
    public function render() {
        $this->parts[] = '<!DOCTYPE html>';
        $this->parts[] = '<html class="no-js">';
            $this->parts[] = $this->context['headControllerResult'];
            $this->parts[] = '<body onload = "Zobraz_pdf();">';     
                $this->parts[] = $this->context['headerControllerResult'];
                $this->parts[] = $this->context['containerControllerResult'];
                $this->parts[] = $this->context['footerControllerResult'];
            $this->parts[] = '</body>';
        $this->parts[] = '</html>';
        return $this;
    }
}
