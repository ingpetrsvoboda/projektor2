<?php
/**
 * Description 
 *
 * @author pes2704
 */
class Projektor2_Model_CertifikatProjekt extends Framework_Model_ItemAbstract {
    public $dbCertifikatProjekt;
    public $documentCertifikatProjekt;

    public function __construct(Projektor2_Model_Db_CertifikatProjekt $dbCertifikatProjekt=NULL, Framework_Model_FileItemAbstract $documentCertifikatProjekt=NULL) {
        $this->dbCertifikatProjekt = $dbCertifikatProjekt;
        $this->documentCertifikatProjekt = $documentCertifikatProjekt;
    }    
}
