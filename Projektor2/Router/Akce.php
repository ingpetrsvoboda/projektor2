<?php
/**
 * Description of Projektor2_Router_Akce
 *
 * @author pes2704
 */
class Projektor2_Router_Akce {  

    protected $sessionStatus;
    protected $request;
    protected $response;
    
    public function __construct(Projektor2_Model_SessionStatus $sessionStatus, Projektor2_Request $request, Projektor2_Response $response) {
        $this->sessionStatus = $sessionStatus;
        $this->request = $request;
        $this->response = $response;
    }
            
    public function getController() {
        
        // Udělátko pro spuštění testů. Každý test musí být kontroler.
        if ($this->request->get('akce') == 'test') {
            $testClassName = $this->request->get('testclass');
            return new $testClassName();
        }        
        
        //Volba akce
        switch ($this->sessionStatus->projekt->kod) {
            case "AGP":
                switch($this->request->param('akce')) {
                ///** AGP **/                
                    case "zobraz_reg":
                        return new Projektor2_Controller_Agp_ZobrazeniRegistraci($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "agp_export":
                        return new Projektor2_Controller_Help_Export($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "form":
                        $router = new Projektor2_Router_Form($this->sessionStatus, $this->request, $this->response);
                        return $router->getController();
                        break;
                    case "logout":
                        return new Projektor2_Controller_Logout($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        return new Projektor2_Controller_Agp_ZobrazeniRegistraci($this->sessionStatus, $this->request, $this->response);   
                }
                break;
            case "HELP":
                switch($this->request->param('akce')) {            
                /** HELP **/                  
                    case "he_export":
                        return new Projektor2_Controller_Export_Excel($this->sessionStatus, $this->request, $this->response);
                        break;                      
                    case "form":
                        return new Projektor2_Controller_Formular($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "logout":
                        return new Projektor2_Controller_Logout($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "zobraz_reg":
                        return new Projektor2_Controller_ZobrazeniRegistraci($this->sessionStatus, $this->request, $this->response);
                    default:
                        return new Projektor2_Controller_ZobrazeniRegistraci($this->sessionStatus, $this->request, $this->response);
                        break; 
                }
            break;
            case "AP":
                switch($this->request->param('akce')) {            
                /** AP **/        
                    case "ap_export":
                        return new Projektor2_Controller_Export_Excel($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "ap_ip_certifikaty_export":
                        return new Projektor2_Controller_Export_CertifikatyKurz($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "ap_projekt_certifikaty_export":
                        return new Projektor2_Controller_Export_CertifikatyProjekt($this->sessionStatus, $this->request, $this->response);
                        break;                       
                    case "form":
                        return new Projektor2_Controller_Formular($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "logout":
                        return new Projektor2_Controller_Logout($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "zobraz_reg":
                        return new Projektor2_Controller_ZobrazeniRegistraci($this->sessionStatus, $this->request, $this->response);
                    default:
                        return new Projektor2_Controller_ZobrazeniRegistraci($this->sessionStatus, $this->request, $this->response);
                        break;                        
                }
            break;
            case "SJZP":
                switch($this->request->param('akce')) {            
                /** SJZP **/                   
                    case "sj_export":
                        return new Projektor2_Controller_Export_Excel($this->sessionStatus, $this->request, $this->response);
                        break;                      
                    case "form":
                        return new Projektor2_Controller_Formular($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "logout":
                        return new Projektor2_Controller_Logout($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "zobraz_reg":
                        return new Projektor2_Controller_ZobrazeniRegistraci($this->sessionStatus, $this->request, $this->response);
                    default:
                        return new Projektor2_Controller_ZobrazeniRegistraci($this->sessionStatus, $this->request, $this->response);
                        break;  
                }
            break;
            default:
                throw new UnexpectedValueException('neznámý kód projektu: '.$this->sessionStatus->projekt->kod);
                        
        }
    }
}

?>
