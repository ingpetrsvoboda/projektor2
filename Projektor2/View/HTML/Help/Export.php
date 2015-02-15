<?php
/**
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Help_Export extends Framework_View_Abstract {

    public function render() {
        $this->parts[] = '<h3>Export tabulkových přehledů</h3>';
        $this->parts[] = '<div class="left">
                                <ul id="menu">
                                    <hr>
                                    <li><a href="index.php?akce=select_beh">Zpět na výběr běhu</a></li>
                                    <li><a href="index.php?akce=seznam">Zpět na zobrazení registrací</a></li>';                                    
        $this->parts[] = '        </ul>
                        </div>';
        $this->parts[] = '<div class="content">';
            $this->parts[] = '
                            <form method="POST" action="index.php?akce=he_export" name="vyber_tabulky">
                                  Databázové tabulky: <br>
                                <select ID="dbtabulka" size="1" name="dbtabulka">
                                <option >------------</option>
                                <option >v_help_zajemci</option>
                                </select><br>
                                <input type="submit" value="Export" name="E1">
                            </form>';
        $this->parts[] = '</div>';
        return $this;
    }
}

?>
