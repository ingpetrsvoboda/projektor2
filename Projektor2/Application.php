<?php
/**
 * Description of Application
 *
 * @author pes2704
 */
class Projektor2_Application {

    protected $request;
    protected $response;
    
    public function __construct(Projektor2_Request $request, Projektor2_Response $response) {
        $this->request = $request;
        $this->response = $response;
    }
    
}

?>
