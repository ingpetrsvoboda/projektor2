<?php
/**
 * Kontejner na statickou hlavičku a patičku PDF stránky
 * @author Petr Svoboda
 *
 */
abstract class Projektor2_PDFContext
{
    private static $hlava;
    private static $pata;
    private static $deb;

    /**
     * Statická funkce, pči prvním volání vytvoří nový objekt PDF_Hlavicka, při každém dalším volání vrací již jednou vytvořený objekt
     * @return Projektor2_PDF_Hlavicka
     */
    public static function getHlavicka() {
        if(!self::$hlava)
        self::$hlava = new Projektor2_PDF_Hlavicka();
        return self::$hlava;
    }

    /**
     * Statická funkce, pči prvním volání vytvoří nový objekt PDF_Paticka, při každém dalším volání vrací již jednou vytvořený objekt
     * @return Projektor2_PDF_Paticka
     */
    public static function getPaticka() {
        if(!self::$pata)
        self::$pata = new Projektor2_PDF_Paticka();
        return self::$pata;
    }

    public static function getDebug()
    {
        if(!self::$deb)
        self::$deb = new Projektor2_PDF_Debug();
        return self::$deb;
    }
}
