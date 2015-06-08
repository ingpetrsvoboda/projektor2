<?php
/**
 * Description of Projektor2_View_HTML_Element
 * Použití:
 * a) new Projektor2_View_HTML_Element($context, $atributes, 'input');
 * b) potomkovská třída s definovanou konstantou TAG (např. class Projektor2_View_HTML_Element_Input() 
 *    s definovanou const TAG = 'input')
 *    a volání: new Projektor2_View_HTML_Element_Input($context, $atributes);
 * c) new Projektor2_View_HTML_Element($context, $atributes); vytvoří default element div
 * @author pes2704
 */
abstract class Projektor2_View_HTML_Tag extends Framework_View_Abstract implements Projektor2_View_HTML_TagInterface {
    
    protected $tag;
    
    /**
     *
     * @var Projektor2_View_HTML_Tag_Attributes 
     */
    protected $attributes;
    
    protected $childrens = array();
    
    public function setAttributes(Projektor2_View_HTML_Tag_Attributes $attributes=NULL) {
        $this->attributes = $attributes;
        return $this;
    }
    
    protected function setTag($tag) {
        $this->tag = $tag;
        return $this;
    }
    
    public function addChild(Projektor2_View_HTML_Tag $element) {
        $this->childrens[] = $element;
        return $this;
    }
    
    public function addHtmlPart($html) {
        $this->childrens[] = $html;
        return $this;
    }
    
    public function render() { 
        if (isset($this->attributes)) {
            $this->parts = array_merge(array('<'.$this->tag.' '.$this->attributes->getAttributesString().'>'), $this->childrens, array('</'.$this->tag.'>'));
        } else {
            $this->parts = array_merge(array('<'.$this->tag.'>'), $this->childrens, array('</'.$this->tag.'>'));            
        }
        return $this;
    }    
}

