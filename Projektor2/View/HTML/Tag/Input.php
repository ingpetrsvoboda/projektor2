<?php
/**
 * Description of Projektor2_View_HTML_Element_Input
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Tag_Input extends Projektor2_View_HTML_Tag {

    public function __construct(array $context=NULL, Projektor2_View_HTML_Tag_Attributes_Input $attributes=NULL) {
        parent::__construct($context);
        $this->setTag('input');
        $this->setAttributes($attributes);
    }}

?>
