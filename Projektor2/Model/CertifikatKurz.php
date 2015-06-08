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
     * @var Projektor2_Model_File_ItemAbstract 
     */
    public $documentCertifikatKurz;

    public function __construct(Projektor2_Model_Db_CertifikatKurz $dbCertifikatKurz=NULL, Projektor2_Model_File_ItemAbstract $documentCertifikatKurz=NULL) {
        $this->dbCertifikatKurz = $dbCertifikatKurz;
        $this->documentCertifikatKurz = $documentCertifikatKurz;
    }    
}
