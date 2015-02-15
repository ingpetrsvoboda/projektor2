<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of Abstract
 *
 * @author pes2704
 */
abstract class Projektor2_Controller_Ap_Certifikat_Abstract implements Projektor2_Controller_ControllerParamsInterface {   
    
    protected $sessionStatus;
    protected $request;
    protected $response; 
    protected $params;

    protected $models;
    
    public function __construct(Projektor2_Model_SessionStatus $sessionStatus, Projektor2_Request $request, Projektor2_Response $response, array $params=array()) {
        $this->sessionStatus = $sessionStatus;
        $this->request = $request;
        $this->response = $response;
        $this->params = $params;
    }
    
    protected function createFormModels(Projektor2_Model_Db_Zajemce $zajemce) {
       
         $this->models['plan'] = new Projektor2_Model_Db_Flat_ZaPlanFlatTable($zajemce); 
         $this->models['dotaznik']= new Projektor2_Model_Db_Flat_ZaFlatTable($zajemce);
    }
    
    protected function createContextFromModels() {
        foreach ($this->models as $modelSign => $model) {
            $assoc = $model->getValuesAssoc();
            foreach ($assoc as $key => $value) {
                $context[$modelSign.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.$key] = $value;
            }
        }        
        return $context;
    }
}
