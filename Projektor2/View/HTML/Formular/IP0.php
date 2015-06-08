<?php
/**
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Formular_IP0 extends Framework_View_Abstract {
    
    const MODEL_PLAN = 'plan';

    public function render() {
        $this->parts[] = '<div>';
        $this->parts[] = '<H3>'.$this->context['nadpis'].'</H3>';
        $this->parts[] = '<form method="POST" action="index.php?akce=form&form='.$this->context['formAction'].'" name="'.self::MODEL_PLAN.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'form_ip1">';

        $this->parts[] = '<p>';
        $this->parts[] = 'Datum vytvoření:<input ID="datum_vytvor_dok" type="date" name="'.self::MODEL_PLAN.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'datum_vytvor_dok_plan" size="8" maxlength="10" value="'.$this->context[self::MODEL_PLAN.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'datum_vytvor_dok_plan'].'" required >';
        $this->parts[] = '</p>';
        $this->parts[] = '<p>';
        $this->parts[] = '<input type="submit" value="'.$this->context['submitUloz']['value'].'" '
                . 'name="'.$this->context['submitUloz']['name'].'">';
        $this->parts[] = '</p> ';
        //TISK
        if ($this->context[self::MODEL_PLAN.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'id_zajemce']){
            $this->parts[] = '<p>';
            $this->parts[] = '<input type="submit" value="'.$this->context['submitTiskIP0']['value'].'" '
                    . 'name="'.$this->context['submitTiskIP0']['name'].'">';
            $this->parts[] = '</p> ';
        }
        $this->parts[] = '</form>';
        $this->parts[] = '</div>';
        return $this;
    }
}
?>
