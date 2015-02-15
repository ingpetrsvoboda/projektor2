<?php
/**
 * Description 
 *
 * @author pes2704
 */
class Projektor2_Model_CertifikatKurz extends Framework_Model_ItemAbstract {
    /**
     * @var Projektor2_Model_Db_CertifikatKurz 
     */
    public $dbCertifikatKurz;
    /**
     * @var Framework_Model_FileItemAbstract 
     */
    public $documentCertifikatKurz;

    public function __construct(Projektor2_Model_Db_CertifikatKurz $dbCertifikatKurz=NULL, Framework_Model_FileItemAbstract $documentCertifikatKurz=NULL) {
        $this->dbCertifikatKurz = $dbCertifikatKurz;
        $this->documentCertifikatKurz = $documentCertifikatKurz;
    }    
}
