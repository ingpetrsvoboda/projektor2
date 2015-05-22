<?php
/**
 * Description of Chyby
 *
 * @author pes2704
 */
abstract class Projektor2_View_HTML_Element extends Framework_View_Abstract implements Projektor2_View_HTML_ElementInterface {
     
    /**
     *
     * @var Projektor2_View_HTML_Element_Attributes 
     */
    protected $attributes;
    
    protected $childrens;
    
    public function __construct(array $context=NULL, Projektor2_View_HTML_Element_Attributes $atributes=NULL) {
        parent::__construct($context);
        $this->attributes = $atributes;
    }
    
    public function addChild(Projektor2_View_HTML_Element $element) {
        $this->childrens[] = $element;
    }
    
    public function addHtmlPart($html) {
        $this->childrens[] = $html;
    }
}

