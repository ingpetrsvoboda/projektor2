<?php
/**
 * Description of Projektor2_View_HTML_ElementInterface
 *
 * @author pes2704
 */
interface Projektor2_View_HTML_TagInterface {
    public function addChild(Projektor2_View_HTML_Tag $element);
    public function addHtmlPart($html);
}

