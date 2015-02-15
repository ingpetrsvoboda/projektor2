<?php

    $id_zajemce = false;
    if(isset($_GET['id_zajemce']) AND $_GET['id_zajemce']) {
        $id_zajemce = $_GET['id_zajemce'];
    } elseif (isset($Zajemce->id)) {
        $id_zajemce = $Zajemce->id;
    }
    if($id_zajemce){
        if($Zajemce = Projektor2_Model_Db_ZajemceMapper::findById($id_zajemce, $dbh)) {
            setcookie("id_zajemce",$Zajemce->id);
            $Flat_table = new Projektor2_Model_Db_Flat_ZaFlatTable($Zajemce);         // !! tab. za_flat_table
            $Flat_table->read_values();
            $pole = $Flat_table->getValuesAssoc();

            echo ("
                <ul id='menu'>
                    <li><a href='index.php?akce=he_zobraz_reg'>Zpět na výběr zájemce</a></li>
                </ul>
                <table border='0'>
                <tr>
                    <td><h2><b>Zájemce: </b>".$pole['titul']." ".$pole['jmeno']." ".$pole['prijmeni']."</h2></td>
                </tr>
                <tr>
                    <td><h3>Číslo zájemce:".$Zajemce->identifikator."</h3></td>

                </tr>
                </table>");
        }
    } else {
        setcookie("id_zajemce");
        $pole=array();
    }
    echo ("
        <ul id='menu'>
            <hr>
            <li><a href='index.php?akce=unset_beh'>Zpět na výběr turnusu</a></li>
        </ul>
        </center>
        <H3>DOHODA O ÚČASTI V PROJEKTU</H3>
          <ul id='menu'>
             <li><a href='index.php?akce=he_zobraz_reg'>Zpět na výběr zájemce</a></li>
          </ul>");
$view = new Projektor2_View_HTML_Help_Smlouva($pole, $id_zajemce);
$view->display();
?>
