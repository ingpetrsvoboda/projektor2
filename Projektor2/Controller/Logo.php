<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Hlavicka
 *
 * @author pes2704
 */
class Projektor2_Controller_Logo extends Projektor2_Controller_Abstract {

    public function getResult() {
        $context = array();
        switch ($this->sessionStatus->projekt->kod) {
            case "NSP":
                $context['nadpis'] = 'PROJEKT NAJDI SI PRÁCI V PLZEŇSKÉM KRAJI';
                $context['src'] = "logoNSP.gif";
                $context['alt'] = "Logo projektu Najdi si práci";
                break;
            case "PNP":
                $context['nadpis'] = 'PROJEKT PŘÍPRAVA NA PRÁCI V PLZEŇSKÉM KRAJI';
                $context['src'] = "logoPNP.gif";
                $context['alt'] = "Logo projektu Příprava na práci";
                break;
            case "SPZP":
                $context['nadpis'] = 'PROJEKT S POMOCÍ ZA PRACÍ';
                $context['src'] = "logo_spzp.jpg";
                $context['alt'] = "Logo projektu S pomocí za prací";
                break;
            case "RNH":
                $context['nadpis'] = 'PROJEKT RODINA NENÍ HANDICAP';
                $context['src'] = "logo_rnh.jpg";
                $context['alt'] = "Logo projektu Rodina není handicap";
                break;
            case "AGP":
                $context['nadpis'] = 'AGENTURA PRÁCE';
                $context['src'] = "logo_agp.png";
                $context['alt'] = "Logo Personal Service";
                break;
            case "HELP":
                $context['nadpis'] = 'PROJEKT HELP50+';
                $context['src'] = "logo_Help50.png";
                $context['alt'] = "Logo projektu Help50+";
                break;
            case "AP":
                $context['nadpis'] = 'PROJEKT ALTERNATIVNÍ PRÁCE';
                $context['src'] = "logo_AP.png";
                $context['alt'] = "Logo projektu Alternativní práce v Plzeňském kraji";
                break;
            case "SJZP":
                $context['nadpis'] = 'PROJEKT S JAZYKY ZA PRACÍ';
                $context['src'] = "logo_S_JAZYKY_ZA_PRACI.png";
                $context['alt'] = "Logo projektu S jazyky za prací";
                break;            
            default:
                break;
        }        
        $view = new Projektor2_View_HTML_Logo($context);
        $html = $view->render();
        return $html;
    }
}

?>
