<?php
/**
 * Description of Projektor2_View_HTML_ElementInterface
 *
 * @author pes2704
 */
interface Projektor2_View_HTML_ElementInterface {
    public function addChild(Projektor2_View_HTML_Element $element);
    public function addHtmlPart($html);
}

