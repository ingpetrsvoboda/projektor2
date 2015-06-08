<?php
/**
 * Description of Chyby
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Tag_Legend extends Projektor2_View_HTML_Tag {

    public function __construct(array $context=NULL, Projektor2_View_HTML_Tag_Attributes_Legend $attributes=NULL) {
        parent::__construct($context);
        $this->setTag('legend');
        $this->setAttributes($attributes);
    }    
}

?>
