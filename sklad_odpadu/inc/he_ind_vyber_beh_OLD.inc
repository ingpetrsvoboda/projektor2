<?php

?>

<h2>Registrace zájemců</h2>
<hr>
    <form name="Beh" ID="Beh" action="index.php" method="post">
    <input type="hidden" name="akce" value="he_zobraz_reg">
    <label for="beh" >Vyberte běh :</label>
    <select ID="beh" size="1" name="beh">
<?php
            $query="SELECT id_s_beh_projektu,beh_cislo,text
                    FROM s_beh_projektu
                    WHERE id_c_projekt = :1 and valid=1";
            $data=$dbh->prepare($query)->execute($sessionStatus->id_c_projekt->id);
            while ($radek = $data->fetch()){
                echo "<option value=\"".$radek['id_s_beh_projektu']."\">".$radek['text'];
                
                //$datum = new Datum($radek['zacatek'],"MySQL");
                //echo " - od ".$datum->f_web;
                //If( $radek['konec'] !=NULL) {
                //    $datum = new Datum($radek['konec'],"MySQL");
                //    echo " do ".$datum->f_web;
                //}
                
                echo "</option>\n";
            }
?>
    </select>
    <br><br>
    <input type="submit" value="Zobrazit registrace">
    </form>  
<hr>


  

    
