<?php
/**
 * Description of LeftMenu
 *
 * @author pes2704
 */
class Projektor2_View_HTML_LeftMenu extends Framework_View_Abstract  {
    public function render() {
        $this->parts[] = '<div class="left">';
            $this->parts[] = '<ul id="menu">';
            foreach($this->context['menuArray'] as $menuItem) {
                $this->parts[] = '<li><a href="'.$menuItem['href'].'">'.$menuItem['text'].'</a></li>';
            }
            $this->parts[] = '</ul>';
        $this->parts[] = '</div>';
        return $this;
    }
}
