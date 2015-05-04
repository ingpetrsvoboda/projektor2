<?php
/**
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Formular_IP1 extends Framework_View_Abstract {
    
    const MODEL_PLAN = 'plan';
    public function render() {
        $this->parts[] = '<div>';        
        $this->parts[] = '<H3>'.$this->context['nadpis'].'</H3>';
        $this->parts[] = '<H4>Plán aktivit</H4>';
        $this->parts[] = '<form method="POST" action="index.php?akce=form&form='.$this->context['formAction'].'" name="form_plan">';
                
        foreach ($this->context['kurzyModels'] as $druhKurzu=>$sKurzyJednohoDruhu) {
                $view = new Projektor2_View_HTML_Element_KurzFieldset($this->sessionStatus, $this->context);    
                $view->assign('planPrefix', self::MODEL_PLAN)
                    ->assign('druhKurzu', $druhKurzu)
                    ->assign('modelsArray', $sKurzyJednohoDruhu)
                    ->assign('returnedModelProperty', 'id')
                    ->assign('aktivita', $this->context['aktivityProjektuTypuKurz'][$druhKurzu])
                    ->assign('kurzPlan', $this->context['kurzyPlan'][$druhKurzu])
                    ->assign('readonly', FALSE);
                $this->parts[] = $view; 
        }        

        $this->parts[] = '<br>';
        $this->parts[] = '<p>Datum vytvoření:';
        $this->parts[] =   '<input type="date" id="datum_vytvor_dok" size="8" maxlength="10" '
                    . 'name="'.self::MODEL_PLAN.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'datum_upravy_dok_plan" '
                    . 'value="'.$this->context['plan->datum_upravy_dok_plan'].'" required >';
        $this->parts[] = '</p>';
        $this->parts[] = '<p>';
        $this->parts[] = '<input type="submit" value="'.$this->context['submitUloz']['value'].'" name="'.$this->context['submitUloz']['name'];
        $this->parts[] = '&nbsp;&nbsp;&nbsp;</p> ';
        $this->parts[] =   '<input type="reset" name="reset" value="Zruš provedené změny" >';
        $this->parts[] = '</p>';
        //TISK
        if ($this->context[self::MODEL_PLAN.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'id_zajemce']){   
            $this->parts[] = '<p><input type="submit" value="'.$this->context['submitTiskIP1']['value'].'" name="'.$this->context['submitTiskIP1']['name'].'">&nbsp;&nbsp;&nbsp;</p> ';            
        }
        $this->parts[] = '</form>';     
        $this->parts[] = '</div>';        
        return $this;
    }
}
?>
