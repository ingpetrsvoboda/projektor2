<?php
class Projektor2_Model_ZajemceRegistraceMapper {
    /**
     * Metoda vyhledá a vytvoří model podle id tabulky zajemce. Id modelu je shodné z id zajemce.
     * @param integer $id
     * @return Projektor2_Model_ZajemceRegistrace
     */
    public static function findById($id) {
        $zajemce = Projektor2_Model_ZajemceOsobniUdajeMapper::findById($id);
        return self::create($zajemce);
    }
    
    public static function findAll($filter = NULL, $order = NULL) {
        $zajemci = Projektor2_Model_ZajemceRegistraceMapper::findAll($filter, $order);
        if ($zajemci) {
            foreach ($zajemci as $zajemce) {
                $zajemciRegistrace[] = self::create($zajemce);
            }
        } else {
            return array();
        }
        return $zajemciRegistrace;
    }
    
    public static function create(Projektor2_Model_ZajemceOsobniUdaje $zajemceOsobniUdaje) {
        $jmenoCele = implode(' ', array($zajemceOsobniUdaje->prijmeni, $zajemceOsobniUdaje->jmeno, $zajemceOsobniUdaje->titul, $zajemceOsobniUdaje->titul_za)); //začíná příjmením 
        $zajemceRegistrace =  new Projektor2_Model_ZajemceRegistrace($jmenoCele, $zajemceOsobniUdaje->zajemce->identifikator, $zajemceOsobniUdaje->zajemce->znacka, $zajemceOsobniUdaje->zajemce->id);   
        return self::setSkupiny($zajemceRegistrace, $zajemceOsobniUdaje->zajemce);
    }

    ######### PRIVATE #######################

    private static function setSkupiny(Projektor2_Model_ZajemceRegistrace $zajemceRegistrace, Projektor2_Model_Db_Zajemce $zajemce) {
        $user = Projektor2_Model_SessionStatus::getSessionStatus()->user;
        $sessionSratus = Projektor2_Model_SessionStatus::getSessionStatus();
        $kod = $sessionSratus->projekt->kod;
        switch ($kod) {
            case 'AP':
                // příprava na                     $modelTlacitko->status = 'disabled';
//                $dotaznik = new Projektor2_Model_Db_Flat_ZaFlatTable($zajemce);
//                $plan = new Projektor2_Model_Db_Flat_ZaPlanFlatTable($zajemce);
//                $ukonceni = new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce);
//                $zamestnani = new Projektor2_Model_Db_Flat_ZaZamFlatTable($zajemce);

                // skupina dotaznik
                $skupina = new Projektor2_Model_Menu_Skupina();
                //smlouva
                if ($user->tl_ap_sml) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'ap_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_ap_sml', $modelTlacitko);
                }
                //souhlas se zpracováním osobních údajů
                if ($user->tl_ap_souhlas) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'ap_souhlas_uc';
                    $modelTlacitko->text = 'Souhlas';
                    $modelTlacitko->title = 'Tisk souhlasu se zpracováním osobních údajů';
                    $modelTlacitko->status = 'print';
                    $skupina->setMenuTlacitko('tl_ap_souhlas', $modelTlacitko);
                }	
                //dotazník
                if ($user->tl_ap_dot) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'ap_reg_dot';
                    $modelTlacitko->text = 'Dotazník';
                    $modelTlacitko->title = 'Úprava údajů dotazníku účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_ap_dot', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('dotaznik', $skupina);
                }
                
                // skupina plan
                $skupina = new Projektor2_Model_Menu_Skupina();                
                //IP1
                if ($user->tl_ap_ip1) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'ap_ip1_uc';
                    $modelTlacitko->text = 'IP1';
                    $modelTlacitko->title = 'První část plánu kurzů a aktivit';
                    $modelTlacitko->status = 'print';
                    $skupina->setMenuTlacitko('tl_ap_ip1', $modelTlacitko);
                }        
                //plán
                if ($user->tl_ap_plan) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'ap_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_ap_plan', $modelTlacitko);
                }        
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('plan', $skupina);
                    $kolekceAktivityPlan = Projektor2_Model_AktivityPlanMapper::findAll($sessionSratus, $zajemce);
                    if ($kolekceAktivityPlan) {
                        foreach ($kolekceAktivityPlan as $aktivitaPlan) {
//                            $aktivitaPlan = new Projektor2_Model_AktivitaPlan();  // jen pro našeptávání
                            $modelSignal = new Projektor2_Model_Menu_Signal_Plan();
                            $modelSignal->setByAktivitaPlan($aktivitaPlan);
                            $skupina->setMenuSignal($aktivitaPlan->indexAktivity, $modelSignal);   
                        }
                    }
                }
//              bez signalu:
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('plan', $skupina);
//                } 
//                                               
//                //poradenství
//                if ($user->tl_ap_porad) {
//                    $modelTlacitko = new Projektor2_Model_MenuTlacitko();
//                    $modelTlacitko->form = 'ap_porad_uc';
//                    $modelTlacitko->text = 'Plán poradenství';
//                    $modelTlacitko->title = 'Úprava údajů plánu poradenských aktivit';
//                    $modelTlacitko->status = 'edit';
//                    $skupina->setMenuTlacitko('tl_ap_porad', $modelTlacitko);
//                }

                // skupina ukonceni
                $skupina = new Projektor2_Model_Menu_Skupina();                
                //ukončení
                if ($user->tl_ap_ukon) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'ap_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_ap_ukon', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
                }
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
//                    $kolekceAktivityPlan = Projektor2_Model_AktivityPlanMapper::findAll($sessionSratus, $zajemce);
//                    if ($kolekceAktivityPlan) {
//                        foreach ($kolekceAktivityPlan as $aktivitaPlan) {
////                            $aktivitaPlan = new Projektor2_Model_AktivitaPlan();  // jen pro našeptávání
//                            $modelSignal = new Projektor2_Model_Menu_Signal_Plan();
//                            $modelSignal->setByAktivitaPlan($aktivitaPlan);
//                            $skupina->setMenuSignal($aktivitaPlan->indexAktivity, $modelSignal);   
//                        }
//                    }
//                }                                                
                // skupina zamestnani
                $skupina = new Projektor2_Model_Menu_Skupina();                
                //zaměstnání
                if ($user->tl_ap_zam) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'ap_zamestnani_uc';
                    $modelTlacitko->text = 'Zaměstnání';
                    $modelTlacitko->title = 'Údaje o zaměstnání účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_ap_zam', $modelTlacitko);
                }        
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('zamestnani', $skupina);
                }
                
                break;
                
            case 'HELP':
                // skupina dotaznik
                $skupina = new Projektor2_Model_Menu_Skupina();                
                //smlouva
                if ($user->tl_he_sml) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'he_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_he_sml', $modelTlacitko);
                }
                //souhlas se zpracováním osobních údajů
                if ($user->tl_he_souhlas) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'he_souhlas_uc';
                    $modelTlacitko->text = 'Souhlas';
                    $modelTlacitko->title = 'Tisk souhlasu se zpracováním osobních údajů';
                    $modelTlacitko->status = 'print';
                    $skupina->setMenuTlacitko('tl_he_souhlas', $modelTlacitko);
                }	
                //dotazník
                if ($user->tl_he_dot) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'he_reg_dot';
                    $modelTlacitko->text = 'Dotazník';
                    $modelTlacitko->title = 'Úprava údajů dotazníku účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_ap_dot', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('dotaznik', $skupina);
                }
                                
                // skupina plan
                $skupina = new Projektor2_Model_Menu_Skupina();                
//                //IP1
//                if ($user->tl_he_ip1) {
//                    $modelTlacitko = new Projektor2_Model_Tlacitko();
//                    $modelTlacitko->form = 'he_ip1_uc';
//                    $modelTlacitko->text = 'IP1';
//                    $modelTlacitko->title = 'První část plánu kurzů a aktivit';
//                    $modelTlacitko->status = 'print';
//                    $zajemceRegistrace->setTlacitko('tl_he_ip1', $modelTlacitko);
//                }        
                //plán
                if ($user->tl_he_plan) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'he_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_he_plan', $modelTlacitko);
                }    
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('plan', $skupina);
                    $kolekceAktivityPlan = Projektor2_Model_AktivityPlanMapper::findAll($sessionSratus, $zajemce);
                    if ($kolekceAktivityPlan) {
                        foreach ($kolekceAktivityPlan as $aktivitaPlan) {
//                            $aktivitaPlan = new Projektor2_Model_AktivitaPlan();  // jen pro našeptávání
                            $modelSignal = new Projektor2_Model_Menu_Signal_Plan();
                            $modelSignal->setByAktivitaPlan($aktivitaPlan);
                            $skupina->setMenuSignal($aktivitaPlan->indexAktivity, $modelSignal);   
                        }
                    }
                }                                  
                //poradenství
//                if ($user->tl_ap_porad) {
//                    $modelTlacitko = new Projektor2_Model_Tlacitko();
//                    $modelTlacitko->form = 'ap_porad_uc';
//                    $modelTlacitko->text = 'Plán poradenství';
//                    $modelTlacitko->title = 'Úprava údajů plánu poradenských aktivit';
//                    $modelTlacitko->status = 'edit';
//                    $zajemceRegistrace->setTlacitko('tl_ap_porad', $modelTlacitko);
//                }
                // skupina ukonceni
                $skupina = new Projektor2_Model_Menu_Skupina();
                //ukončení
                if ($user->tl_he_ukon) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'he_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_he_ukon', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
                }
                                 
                // skupina zamestnani
//                $skupina = new Projektor2_Model_MenuSkupina();
                //zaměstnání
//                if ($user->tl_he_zam) {
//                    $modelTlacitko = new Projektor2_Model_Tlacitko();
//                    $modelTlacitko->form = 'he_zamestnani_uc';
//                    $modelTlacitko->text = 'Zaměstnání';
//                    $modelTlacitko->title = 'Údaje o zaměstnání účastníka projektu';
//                    $modelTlacitko->status = 'edit';
//                    $zajemceRegistrace->setTlacitko('tl_he_zam', $modelTlacitko);
//                } 
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('zamestnani', $skupina);
//                }
                 

                break;
            case 'SJZP':
                // skupina dotaznik
                $skupina = new Projektor2_Model_Menu_Skupina();                
                //smlouva
                if ($user->tl_sj_sml) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'sjzp_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_sj_sml', $modelTlacitko);
                }
                //souhlas se zpracováním osobních údajů
                if ($user->tl_sj_souhlas) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'sjzp_souhlas_uc';
                    $modelTlacitko->text = 'Souhlas';
                    $modelTlacitko->title = 'Tisk souhlasu se zpracováním osobních údajů';
                    $modelTlacitko->status = 'print';
                    $skupina->setMenuTlacitko('tl_sj_souhlas', $modelTlacitko);
                }	
                //dotazník
                if ($user->tl_sj_dot) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'sjzp_reg_dot';
                    $modelTlacitko->text = 'Dotazník';
                    $modelTlacitko->title = 'Úprava údajů dotazníku účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_sj_dot', $modelTlacitko);
                }       
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('dotaznik', $skupina);
                }
                                
                // skupina plan
                $skupina = new Projektor2_Model_Menu_Skupina();                
                //plán
                if ($user->tl_sj_plan) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'sjzp_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_sj_plan', $modelTlacitko);
                } 
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('plan', $skupina);
                    $kolekceAktivityPlan = Projektor2_Model_AktivityPlanMapper::findAll($sessionSratus, $zajemce);
                    if ($kolekceAktivityPlan) {
                        foreach ($kolekceAktivityPlan as $aktivitaPlan) {
//                            $aktivitaPlan = new Projektor2_Model_AktivitaPlan();  // jen pro našeptávání
                            $modelSignal = new Projektor2_Model_Menu_Signal_Plan();
                            $modelSignal->setByAktivitaPlan($aktivitaPlan);
                            $skupina->setMenuSignal($aktivitaPlan->indexAktivity, $modelSignal);   
                        }
                    }
                }     
                                  
                //poradenství
//                if ($user->tl_ap_porad) {
//                    $modelTlacitko = new Projektor2_Model_Tlacitko();
//                    $modelTlacitko->form = 'ap_porad_uc';
//                    $modelTlacitko->text = 'Plán poradenství';
//                    $modelTlacitko->title = 'Úprava údajů plánu poradenských aktivit';
//                    $modelTlacitko->status = 'edit';
//                    $zajemceRegistrace->setTlacitko('tl_ap_porad', $modelTlacitko);
//                }
                // skupina ukonceni
                $skupina = new Projektor2_Model_Menu_Skupina();
                //ukončení
                if ($user->tl_sj_ukon) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'sjzp_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_sj_ukon', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
                }
                                  
                // skupina zamestnani
                $skupina = new Projektor2_Model_Menu_Skupina();                
                //zaměstnání
                if ($user->tl_sj_zam) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'sjzp_zamestnani_uc';
                    $modelTlacitko->text = 'Zaměstnání';
                    $modelTlacitko->title = 'Údaje o zaměstnání účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_sj_zam', $modelTlacitko);
                }        
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('zamestnani', $skupina);
                }
 
                break;
                
                default:
                    throw new UnexpectedValueException('Nelze nastavit tlačítka. Neznámý kód projektu '.$kod);
                break;

        }
        
        return $zajemceRegistrace;
    }
}
