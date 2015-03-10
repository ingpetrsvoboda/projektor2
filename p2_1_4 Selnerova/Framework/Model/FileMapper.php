<?php
/**
 * Description of FileMapper
 *
 * @author pes2704
 */
abstract class Framework_Model_FileMapper {

    protected $fileLength;
    
    /**
     * Metoda ukládá dokument do souboru v souborovém systému. Soubor vytvoří, již existující vždy přepíše. Do souboru vloží obsah 
     * bez kontroly délky, pokud je obsah modelu prázdný, vytvoří soubor s nulovou délkou.
     * @param Framework_Model_FileItemAbstract $model
     * @return \Framework_Model_FileItemAbstract
     * @throws BadFunctionCallException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     */
    public static function persist(Framework_Model_FileItemAbstract $model) {
        $path_parts = pathinfo($model->documentPath);
        if (!is_dir($path_parts['dirname'])) {  //pokud není složka, vytvoří ji
            if (!mkdir($path_parts['dirname'], 0777, TRUE)) {
                throw new BadFunctionCallException('Nepodařilo se vytvořit složku: '.$path_parts['dirname']);
            }
        }
        if ($model->documentPath != $path_parts['dirname'].'/'.$path_parts['basename']) {
            throw new UnexpectedValueException('Chybná syntaxe názvu souboru ve vlastnosti modelu '.get_class($model).'. Chybný název souboru: '.$model->documentPath);
        }        
        $fileResource = fopen($model->documentPath, 'w+'); //pokud soubor existuje, přepíše ho, pokud ne, vytvoří ho 
        $model->filelength = fwrite($fileResource, $model->content);
        if (self::isSaved($model)) {
            $model->isPersisted = TRUE;
            $model->changed = FALSE;
            return $model;            
        } else {
            throw new RuntimeException('Neznámá chyba! Soubor '.$model->documentPath.' se nepodařilo uložit.');
        }
    }

    /**
     * Metoda načte obsah souboru v souborové systému do obsahu modelu a nastaví ostatní vlastnosti modelu.
     * @param Framework_Model_FileItemAbstract $model
     * @return \Framework_Model_FileItemAbstract Model s načteným obsahem
     * @throws RuntimeException
     */
    public static function hydrate(Framework_Model_FileItemAbstract $model) {
        $path_parts = pathinfo($model->documentPath);
        if (!isset($path_parts['dirname'])) {
            throw new RuntimeException('Při pokusu o načtení obsahu certifikátu ze souboru se nepodařilo zjistit složku a název souboru '
                    . 'z vlastnosti modelu:'.$model->documentPath);            
        }
        if (!is_dir($path_parts['dirname'])) {
            throw new RuntimeException('Při pokusu o načtení obsahu ze souboru '.$model->documentPath
                    .' neexistuje složka: '.$path_parts['dirname']);
        }        
        $fileResource = fopen($model->documentPath, 'r'); //jen ke čtení
        if (!$fileResource) {
            throw new RuntimeException('Při pokusu o načtení obsahu ze souboru '.$model->documentPath.
                    ' neexistuje soubor: '.$model->documentPath);
        }
        $ret = fread($fileResource, filesize($model->documentPath));
        if ($ret === FALSE) {
            throw new RuntimeException('Při pokusu o načtení obsahu ze souboru '.$model->documentPath
                    .'se nepodařilo přečíst existující soubor '.$model->documentPath);
        } else {
            $model->content = $ret;
            $model->filelength = strlen($ret);
            if (self::isHydrated($model)) {  //přísné ověřování
                $model->isHydrated = TRUE;
            } else {
                throw new RuntimeException('Neznámá chyba! Soubor '.$model->documentPath.' se podařilo načíst a přesto je obsah modelu jiný než obsah souboru.');
            }
            $model->changed = FALSE;
        }
        return $model;
    }
    
    /**
     * Metoda ověří, jestli je obsah modelu souboru v souborovém systému. 
     * @param Framework_Model_FileItemAbstract $model
     * @return boolean
     */
    public static function isSaved(Framework_Model_FileItemAbstract $model) {
        return self::verify($model);
    }
    
    /**
     * Metoda ověří, jestli jestli obsah souboru v souborovém systému je obsahem modelu. 
     * @param type $model
     * @return type
     */
    public static function isHydrated($model) {
        return self::verify($model);
    }
    
    /**
     * Zjistí jestli existuje soubor, nezměnil se obsah modelu od posledního uložení a nezměnil se obsah souboru od posledního uložení. 
     * Změnu obsahu zjišťuji jen podle změny délky (počtu bytů).
     * @param type $model
     * @return boolean
     */
    private static function verify($model) {
        if (file_exists($model->documentPath) 
            AND strlen($model->content)===$model->filelength 
            AND $model->filelength==filesize($model->documentPath)) {
            return TRUE;
        }
        return FALSE;        
    }
}
