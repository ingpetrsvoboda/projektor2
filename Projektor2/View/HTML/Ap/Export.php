<?php
/**
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Ap_Export extends Framework_View_Abstract {

    public function render() {
        $this->parts[] = '<h3>Export tabulkových přehledů</h3>';
        $this->parts[] = '<div class="left">
                                <ul id="menu">
                                    <hr>
                                    <li><a href="index.php?akce=seznam">Zpět na zobrazení registrací</a></li>';                                    
        $this->parts[] = '        </ul>
                        </div>';
        $this->parts[] = '<div class="content">';
            $this->parts[] = '
                            <form method="POST" action="index.php?akce=ap_export" name="vyber_tabulky">
                                  Databázové tabulky: <br>
                                <select ID="dbtabulka" size="1" name="dbtabulka">
                                <option >------------</option>
                                <option value=v_ap_zajemci>Všichni účastníci projektu</option>
                                <option value=v_ap_kurzy>Všechny kurzy projektu</option>
                                <option value=v_ap_plan_kurzu>Všechny naplánované kurzy</option>
                                <option value=v_mi_vstoupily>Monitoring - vstoupili</option>
                                <option value=v_mi_vstoupily_souhrn_kancelare>Monitoring - vstoupili - souhrn kancelare</option>
                                <option value=v_mi_vstoupily_souhrn_celkem>Monitoring - vstoupili - souhrn celkem</option>
                                
                                <option value=v_mi_zahajily>Monitoring - zahajili</option>
                                <option value=v_mi_zahajily_souhrn_kancelare>Monitoring - zahajili - souhrn kancelare</option>
                                <option value=v_mi_zahajily_souhrn_celkem>Monitoring - zahajili - souhrn celkem</option>
                                
                                <option value=v_mi_absolvovaly>Monitoring - absolvovali</option>
                                <option value=v_mi_absolvovaly_souhrn_kancelare>Monitoring - absolvovali - souhrn kancelare</option>
                                <option value=v_mi_absolvovaly_souhrn_celkem>Monitoring - absolvovali - souhrn celkem</option>
                                

                                </select><br>
                                <input type="submit" value="Export" name="E1">
                            </form>';
        $this->parts[] = '</div>';
        return $this;
    }
}

?>
