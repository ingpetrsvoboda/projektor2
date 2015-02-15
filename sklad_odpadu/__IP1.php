<?php
/**
 * Třída Projektor2_View_HTML_HeSmlouva zabaluje původní PHP4 kód do objektu. Funkčně se jedná o konponentu View, 
 * na základě dat předaných konstruktoru a šablony obsažené v metodě display() generuje HTML výstup
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Help_IP1 extends Framework_View_Abstract {
    
    const MODEL_PLAN = 'plan';
    public function render() {
        $pole = $this->context;
        $html[] = '<H3>INDIVIDUÁLNÍ PLÁN ÚČASTNÍKA PROJEKTU Help 50+</H3>';
        $html[] = '<H4>Plán kurzů</H4>';
        $html[] = '<form method="POST" action="index.php?akce=form&form=he_plan_uc" name="form_plan">';
        
        $aktivity = Projektor2_AppContext::getAktivityProjektu('HELP');   
        foreach ($aktivity as $druh=>$aktivita) {
            if ($aktivita['typ']=='kurz') {
                $view = new Projektor2_View_HTML_Element_KurzFieldset($this->context);    
                $view->assign('planPrefix', self::MODEL_PLAN);
                $view->assign('druh', $druh);
                $view->assign('modelsArray', $this->context['kurzy_'.$druh]);
                $view->assign('returnedModelProperty', 'id');
                $view->assign('aktivita', $aktivita);
                $view->assign('readonly', FALSE);
                $html[] = $view; 
//                $html[] = Projektor2_View_HTML_Element_PlanFieldset::renderFieldsetKurz($this->context, 'plan', $druh, $this->context['kurzy_'.$druh], 'id', $aktivita, FALSE);
            }
        }        
        

        $html[] = '<br>';
        $html[] = '<p>Datum vytvoření:<input ID="datum_vytvor_dok_plan" type="date" name="'.self::MODEL_PLAN.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'datum_vytvor_dok_plan" size="8" maxlength="10" value="'.$pole['plan->datum_vytvor_dok_plan'].'"></p>';
        $html[] = '<p>';
        $html[] = '<input type="submit" value="Uložit" name="save">&nbsp;&nbsp;&nbsp<input type="reset" value="Zruš provedené změny" name="reset">';
        $html[] = '</p>';
        //TISK
        if ($pole[self::MODEL_PLAN.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'id_zajemce']){
            $html[] = ' <p><input type="submit" value="Tiskni IP 1.část" name="pdf"></p> ';        
        }
        $html[] = '</form>';     
        return $this->convertToString($html);
    }
}
