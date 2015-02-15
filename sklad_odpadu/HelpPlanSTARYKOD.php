<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HelpPlanSTARYKOD
 *
 * @author pes2704
 */
class HelpPlanSTARYKOD {


<FIELDSET><LEGEND><b>Motivační kurz</b></LEGEND>   
    <p>Motivační kurz:
        <?php      
            echo $this->htmlSelectCode($pole, 'id_s_kurz_mot_FK', $pole['kurzy_mot']);
        ?>
        <br>

        Počet absolvovaných hodin: <input ID="mot_poc_abs_hodin" type="number" pattern="\d+" name="mot_poc_abs_hodin" size="8" maxlength="10" value="<?php echo @$pole['mot_poc_abs_hodin'];?>"><br>
        V případě, že neabsolvoval plný počet hodin, uveďte proč: <input ID="mot_duvod_absence" type="text" name="mot_duvod_absence" size="120" maxlength="120" value="<?php echo @$pole['mot_duvod_absence'];?>">
    </p>
    Dokončeno úspěšně:
    <input ID="mot_dokoceno_uspech" type="radio" name="mot_dokonceno" value="Ano" <?php if (@$pole['mot_dokonceno'] == 'Ano') {echo 'checked';} ?>>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dokončeno neúspěšně:
    <input ID="mot_dokoceno_neuspech" type="radio" value="Ne" name="mot_dokonceno" <?php if (@$pole['mot_dokonceno'] == 'Ne') {echo 'checked';} ?>>
    <br>
    Při neúspěšném ukončení - důvod: <input ID="mot_duvod_neukonceni" type="text" name="mot_duvod_neukonceni" size="120" maxlength="120" value="<?php echo @$pole['mot_duvod_neukonceni'];?>">
    <br>
    <p>
        Datum vydání osvědčení: <input ID="mot_datum_certif" type="date" name="mot_datum_certif" size="8" maxlength="10" value="<?php echo @$pole['mot_datum_certif'];?>">
    </p>
</FIELDSET>
<FIELDSET><LEGEND><b>PC kurz</b></LEGEND>
    <p>PC kurz:
        <?php      
            echo $this->htmlSelectCode($pole, 'id_s_kurz_pc1_FK', $pole['kurzy_pc1']);
        ?>       
        <br>
        Počet absolvovaných hodin: <input ID="pc1_poc_abs_hodin" type="number" type="number" pattern="\d*" name="pc1_poc_abs_hodin" size="8" maxlength="10" value="<?php echo @$pole['pc1_poc_abs_hodin'];?>">
        <br>
        V případě, že neabsolvoval plný počet hodin, uveďte proč: <input ID="pc1_duvod_absence" type="text" name="pc1_duvod_absence" size="120" maxlength="120" value="<?php echo @$pole['pc1_duvod_absence'];?>">
    </p>
    Dokončeno úspěšně:
    <input ID="pc1_dokoceno_uspech" type="radio" name="pc1_dokonceno" value="Ano" <?php if (@$pole['pc1_dokonceno'] == 'Ano') {echo 'checked';} ?>>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dokončeno neúspěšně:
    <input ID="pc1_dokoceno_neuspech" type="radio" value="Ne" name="pc1_dokonceno" <?php if (@$pole['pc1_dokonceno'] == 'Ne') {echo 'checked';} ?>>
    <br>
    Při neúspěšném ukončení - důvod: <input ID="pc1_duvod_neukonceni" type="text" name="pc1_duvod_neukonceni" size="120" maxlength="120" value="<?php echo @$pole['pc1_duvod_neukonceni'];?>">
    <p>
        Datum vydání osvědčení: <input ID="pc1_datum_certif" type="date" name="pc1_datum_certif" size="8" maxlength="10" value="<?php echo @$pole['pc1_datum_certif'];?>">
    </p>
</FIELDSET> 
<FIELDSET><LEGEND><b>Image poradna</b></LEGEND>
    <p>Image poradna:
        <?php      
            echo $this->htmlSelectCode($pole, 'id_s_kurz_im_FK', $pole['kurzy_im']);
        ?>       
        <br>
        Počet absolvovaných hodin: <input ID="im_poc_abs_hodin" type="number" type="number" pattern="\d*" name="im_poc_abs_hodin" size="8" maxlength="10" value="<?php echo @$pole['im_poc_abs_hodin'];?>">
        <br>
        V případě, že neabsolvoval plný počet hodin, uveďte proč: <input ID="im_duvod_absence" type="text" name="im_duvod_absence" size="120" maxlength="120" value="<?php echo @$pole['im_duvod_absence'];?>">
    </p>
    Dokončeno úspěšně:
    <input ID="im_dokoceno_uspech" type="radio" name="im_dokonceno" value="Ano" <?php if (@$pole['im_dokonceno'] == 'Ano') {echo 'checked';} ?>>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dokončeno neúspěšně:
    <input ID="pc1_dokoceno_neuspech" type="radio" value="Ne" name="im_dokonceno" <?php if (@$pole['im_dokonceno'] == 'Ne') {echo 'checked';} ?>>
    <br>
    Při neúspěšném ukončení - důvod: <input ID="im_duvod_neukonceni" type="text" name="im_duvod_neukonceni" size="120" maxlength="120" value="<?php echo @$pole['im_duvod_neukonceni'];?>">
    <p>
        Datum vydání osvědčení: <input ID="im_datum_certif" type="date" name="im_datum_certif" size="8" maxlength="10" value="<?php echo @$pole['im_datum_certif'];?>">
    </p>
</FIELDSET>
<FIELDSET><LEGEND><b>Setkání pro podnikavé</b></LEGEND>
    <p>Setkání pro podnikavé:
        <?php      
            echo $this->htmlSelectCode($pole, 'id_s_kurz_spp_FK', $pole['kurzy_spp']);
        ?>       
        <br>
        Počet absolvovaných hodin: <input ID="spppoc_abs_hodin" type="number" type="number" pattern="\d*" name="spp_poc_abs_hodin" size="8" maxlength="10" value="<?php echo @$pole['spp_poc_abs_hodin'];?>">
        <br>
        V případě, že neabsolvoval plný počet hodin, uveďte proč: <input ID="sppduvod_absence" type="text" name="spp_duvod_absence" size="120" maxlength="120" value="<?php echo @$pole['spp_duvod_absence'];?>">
    </p>
    Dokončeno úspěšně:
    <input ID="spp_dokoceno_uspech" type="radio" name="spp_dokonceno" value="Ano" <?php if (@$pole['spp_dokonceno'] == 'Ano') {echo 'checked';} ?>>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dokončeno neúspěšně:
    <input ID="spp_dokoceno_neuspech" type="radio" value="Ne" name="spp_dokonceno" <?php if (@$pole['spp_dokonceno'] == 'Ne') {echo 'checked';} ?>>
    <br>
    Při neúspěšném ukončení - důvod: <input ID="spp_duvod_neukonceni" type="text" name="spp_duvod_neukonceni" size="120" maxlength="120" value="<?php echo @$pole['spp_duvod_neukonceni'];?>">
    <p>
        Datum vydání osvědčení: <input ID="spp_datum_certif" type="date" name="spp_datum_certif" size="8" maxlength="10" value="<?php echo @$pole['spp_datum_certif'];?>">
    </p>
</FIELDSET>
<FIELDSET><LEGEND><b>Pracovní diagnostika</b></LEGEND>
    <p>Pracovní diagnostika:
        <?php      
            echo $this->htmlSelectCode($pole, 'id_s_kurz_prdi_FK', $pole['kurzy_prdi']);
        ?>       
        <br>
        Počet absolvovaných hodin: <input ID="prdi_poc_abs_hodin" type="number" type="number" pattern="\d*" name="prdi_poc_abs_hodin" size="8" maxlength="10" value="<?php echo @$pole['prdi_poc_abs_hodin'];?>">
        <br>
        V případě, že neabsolvoval plný počet hodin, uveďte proč: <input ID="prdi_duvod_absence" type="text" name="prdi_duvod_absence" size="120" maxlength="120" value="<?php echo @$pole['prdi_duvod_absence'];?>">
    </p>
    Dokončeno úspěšně:
    <input ID="prdi_dokoceno_uspech" type="radio" name="prdi_dokonceno" value="Ano" <?php if (@$pole['prdi_dokonceno'] == 'Ano') {echo 'checked';} ?>>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dokončeno neúspěšně:
    <input ID="prdi_dokoceno_neuspech" type="radio" value="Ne" name="prdi_dokonceno" <?php if (@$pole['prdi_dokonceno'] == 'Ne') {echo 'checked';} ?>>
    <br>
    Při neúspěšném ukončení - důvod: <input ID="prdi_duvod_neukonceni" type="text" name="prdi_duvod_neukonceni" size="120" maxlength="120" value="<?php echo @$pole['prdi_duvod_neukonceni'];?>">
<!--    <p>
        Datum vydání osvědčení: <input ID="prdi_datum_certif" type="date" name="prdi_datum_certif" size="8" maxlength="10" value="<?php echo @$pole['prdi_datum_certif'];?>">
    </p>-->
</FIELDSET>
<FIELDSET><LEGEND><b>Rekvalifikační kurz</b></LEGEND>   
    <p>Rekvalifikační kurz:
        <?php      
            echo $this->htmlSelectCode($pole, 'id_s_kurz_prof1_FK', $pole['kurzy_prof1']);
        ?>    
        <br>
        Počet absolvovaných hodin: <input ID="prof1_poc_abs_hodin" type="number" type="number" pattern="\d*" name="prof1_poc_abs_hodin" size="8" maxlength="10" value="<?php echo @$pole['prof1_poc_abs_hodin'];?>">
        <br>
        V případě, že neabsolvoval plný počet hodin, uveďte proč: <input ID="prof1_duvod_absence" type="text" name="prof1_duvod_absence" size="120" maxlength="120" value="<?php echo @$pole['prof1_duvod_absence'];?>">
    </p>
    Dokončeno úspěšně:
    <input ID="prof1_dokonceno_uspech" type="radio" name="prof1_dokonceno" value="Ano" <?php if (@$pole['prof1_dokonceno'] == 'Ano') {echo 'checked';} ?>>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dokončeno neúspěšně:
    <input ID="prof1_dokonceno_neuspech" type="radio" value="Ne" name="prof1_dokonceno" <?php if (@$pole['prof1_dokonceno'] == 'Ne') {echo 'checked';} ?>>
    <br>
    Při neúspěšném ukončení - důvod: <input ID="prof1_duvod_ukonceni" type="text" name="prof1_duvod_neukonceni" size="120" maxlength="120" value="<?php echo @$pole['prof1_duvod_neukonceni'];?>">
    <p>
        Datum vydání osvědčení: <input ID="prof1_datum_certif" type="date" name="prof1_datum_certif" size="8" maxlength="10" value="<?php echo @$pole['prof1_datum_certif'];?>">
    </p>
</FIELDSET>}
