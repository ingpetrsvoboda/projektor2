<?php
/**
 *
 * @author pes2704
 */
interface Framework_View_Interface {
    public function render();    
    public function appendContext();
    public function assign($name, $value);
    public function __toString();
}

