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
class Projektor2_View_HTML_Zaznamy extends Framework_View_Abstract {
    public function render() {
        $this->parts[] = '<div ID="zaznamy">';
            $this->parts[] = '<table>';
            foreach ($this->context['rows'] as $row) {
                $this->parts[] = $row;
            }
            $this->parts[] = '</table>';
        $this->parts[] = '</div>';
        return $this;
    }
}
