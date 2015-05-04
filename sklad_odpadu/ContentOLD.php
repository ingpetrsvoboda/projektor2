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
class Projektor2_View_HTML_Content extends Framework_View_Abstract {
    public function render() {
        $this->parts[] = '<div class="content">';
        if (isset($this->context['htmlParts']) AND $this->context['htmlParts']) {
            foreach ($this->context['htmlParts'] as $part) {
                $this->parts[] = $part;                
            }
        }        $this->parts[] = '</div>';
        return $this;
    }
}
