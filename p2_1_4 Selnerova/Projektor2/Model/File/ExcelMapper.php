<?php
class Projektor2_Model_File_ExcelMapper {
    
    const PATH_PREFIX = 'Excel/';

    const SQL_FORMAT = "Y-m-d";
    const BUNKA_NADPIS = "A1";
    const LEVY_HORNI_ROH_TABULKY_RADEK = 3; //řádek s titulky - číslováno os nuly
    const LEVY_HORNI_ROH_TABULKY_SLOUPEC = 0; //číslováno os nuly


    public static function create($tabulka) {        
        $locale = 'cs_CZ';
        $validLocale = PHPExcel_Settings::setLocale($locale);
        if (!$validLocale) {
                echo 'Nepodařilo se nastavit lokalizaci '.$locale." - zůstává nastavena výchozí en_us<br />\n";
        }

        $dbh = Projektor2_AppContext::getDb();
        $query = "SHOW COLUMNS FROM ".$tabulka;
        $sth = $dbh->prepare($query);
        $succ = $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);  

        $objPHPExcel = new PHPExcel();
        $objWorksheet = $objPHPExcel->getActiveSheet();
        PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );
        $objPHPExcel->getActiveSheet()->setCellValue(self::BUNKA_NADPIS, 'Obsah databázové tabulky (pohledu) '.$tabulka);
        $cisloSloupce = self::LEVY_HORNI_ROH_TABULKY_SLOUPEC;
        $cisloRadku = self::LEVY_HORNI_ROH_TABULKY_RADEK;
        
        //titulky sloupců
        foreach ($data as $row) {
            $var_typelengh[$cisloSloupce] = split('[()]',$row['Type']);
            $objWorksheet->getCellByColumnAndRow($cisloSloupce, $cisloRadku)->setValue($row['Field']);
            $cisloSloupce++;    
        }
        //data
        $cisloSloupce = self::LEVY_HORNI_ROH_TABULKY_SLOUPEC;
        $cisloRadku = self::LEVY_HORNI_ROH_TABULKY_RADEK + 1;
        $query = "SELECT * FROM ".$tabulka;
        $sth = $dbh->prepare($query);
        $succ = $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);       
        foreach ($data as $row) {
            foreach ($row as $value) {
                if ($var_typelengh[$cisloSloupce][0]=="date") {
                    $datum = PHPExcel_Shared_Date::PHPToExcel(DateTime::createFromFormat(self::SQL_FORMAT, $value));
                    $objWorksheet->getCellByColumnAndRow($cisloSloupce, $cisloRadku)->setValue($datum);                
                    $objWorksheet->getStyleByColumnAndRow($cisloSloupce, $cisloRadku)->getNumberFormat()->setFormatCode("D.M.YYYY");
                } else {
                    $objWorksheet->getCellByColumnAndRow($cisloSloupce, $cisloRadku)->setValue($value);
                }  
                $cisloSloupce++;                     
            }
            $cisloSloupce = 0;
            $cisloRadku++;
        }  
        
        $objPHPExcel->getProperties()->setCreator("Projektor ExportExcel");
        $objPHPExcel->getProperties()->setTitle("Projektor export - tabulka ".$tabulka);
        //$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
        return new Projektor2_Model_File_Excel($objPHPExcel, $tabulka);
    }
    
    public static function save(Projektor2_Model_File_Excel $modelExcel, Projektor2_Model_SessionStatus $sessionStatus) {       
//        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
        $objWriter = new PHPExcel_Writer_Excel5($modelExcel->objPHPExcel);
        try {
            $fullFileName = self::getFullFileName($sessionStatus, $modelExcel->tabulka);
            $objWriter->save($fullFileName); 
        } catch (Exception $e){
            return FALSE;
        }
        $modelExcel->documentFileName = $fullFileName;
        return TRUE;
    }

    /**
     * Generuje řetězec vhodný jako plné jméno souboru (s cestou).
     * @param Projektor2_Model_SessionStatus $sessionStatus
     * @param type $tabulka
     * @return type
     */
    public static function getFullFileName(Projektor2_Model_SessionStatus $sessionStatus, $tabulka) {
        $soubor = $dirName.
        $dirName = Projektor2_AppContext::getDocumentPath($sessionStatus->projekt->kod).static::PATH_PREFIX;
        $basename = self::getBaseName($sessionStatus, $tabulka);
        return $dirName.$basename;        
    }   
    
    /**
     * Generuje řetězec vhodný jako jméno souboru (base name).
     * @param Projektor2_Model_SessionStatus $sessionStatus
     * @param type $tabulka
     * @return type
     */
    public static function getBaseName(Projektor2_Model_SessionStatus $sessionStatus, $tabulka) {
        return $tabulka.'_'.date("Ymd_Hi").'.xls';
    }    
    
    public static function isSaved(Projektor2_Model_File_Excel $modelRxcel) {
        return file_exists($modelRxcel->documentFileName);
    }
}

