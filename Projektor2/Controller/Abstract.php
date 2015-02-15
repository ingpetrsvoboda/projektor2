<?php
/**
 * Description of Base
 *
 * @author pes2704
 */
abstract class Projektor2_Controller_Abstract implements Projektor2_Controller_ControllerParamsInterface {
    
    protected $sessionStatus;
    protected $request;
    protected $response;
    protected $params;
    
    public function __construct(Projektor2_Model_SessionStatus $sessionStatus, Projektor2_Request $request, Projektor2_Response $response, array $params=array()) {
        $this->sessionStatus = $sessionStatus;
        $this->request = $request;
        $this->response = $response;
        $this->params = $params;
    }
    
}
