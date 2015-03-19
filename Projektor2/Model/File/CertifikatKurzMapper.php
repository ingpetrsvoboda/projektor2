<?php
/**
 * Description of FileMapper
 *
 * @author pes2704
 */
class Projektor2_Model_File_CertifikatKurzMapper extends Framework_Model_FileMapper {
    
    public static function create(Projektor2_Model_Db_Projekt $projekt, Projektor2_Model_Db_Zajemce $zajemce, Projektor2_Model_Db_SKurz $sKurz, $content) {
        if (!is_string($content)) {
            throw new UnexpectedValueException('Obsah dokumentu musí být řetězec.');
        }
        return new Projektor2_Model_File_CertifikatKurzOriginal(Projektor2_AppContext::getRelativeDocumentPath($projekt->kod).self::getRelativeFilePath($projekt, $zajemce, $sKurz), $content);
    }    
    
    /**
     * Vytvoří model s obsahem načteným ze souboru se zadanou relativní cestou.
     * @param type $relativeFilePath
     * @return \Projektor2_Model_File_CertifikatKurzOriginal
     */
    public static function findByRelativeFilepath($relativeFilePath) {
        $model = new Projektor2_Model_File_CertifikatKurzOriginal($relativeFilePath);
        try {
            $model = self::hydrate($model);            
        } catch (RuntimeException $exc) {
//            throw new RuntimeException('Nepodařilo se načíst obsah souboru certifikátu. Metoda hydrate hlásí: '.$exc->getMessage());
            return NULL;
        }

        return $model;
    }
    
    /**
     * Generuje relativní cestu k souboru certifikátu. Jméno souboru (base name) skládá s použitím kódu projektu, druhu kurzu a identifikátoru zájemce.
     * @param Projektor2_Model_Db_Projekt $projekt
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @param Projektor2_Model_Db_SKurz $sKurz
     * @return type
     */
    public static function getRelativeFilePath(Projektor2_Model_Db_Projekt $projekt, Projektor2_Model_Db_Zajemce $zajemce, Projektor2_Model_Db_SKurz $sKurz) {
        // rozděluje soubory do podsložek s názvem rovným id kurzu
        $dirName = static::PATH_PREFIX.$sKurz->id.'/';
        $basename = $projekt->kod.'_IP_Osvedceni_'.$sKurz->kurz_druh.' '.$zajemce->identifikator.'.pdf';;
        return $dirName.$basename;        
    }    
}
