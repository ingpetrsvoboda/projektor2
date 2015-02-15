<?php
class Projektor2_Model_Db_Flat_ZaFlatTable extends Framework_Model_ItemFlatTable {
    
    /**
     * Třída základního (výchozího) objektu flat table pro hlavní objekt zájemce. Tento základní objekt flat table je používán 
     * jako povinný objekt, tedy objekt obsahující povinná data zájemce. Jako jediný objekt typu flat table umožňuje nejprve vytvořit 
     * objekt flat table a následně automaticky vytvoří svůj hlavní objekt zájemce. Všechny ostatní objekty flat table očekávají existenci 
     * objektu zajemce již při svém volání.
     * 
     * V této třídě je přípustná hodnota parametru pro zadání hlavního objektu $zajemce=NULL. Rodičovský konstruktor 
     * se volá s nastaveným parametrem $mainObjectMapperClassName. 
     * Tato třída díky tomu umožňuje vytvořit nový objekt i bez existence hlavního objektu. To umožňuje vytvořit nejdříve objekt 
     * Projektor2_Model_Db_Flat_ZaFlatTable, zobrazit formulář pro zadání hodnot a po odeslání dat formuláře, typicky při zpracování POST 
     * požadavku, těsně před tím, než dojde k uložení dat objektu Projektor2_Model_Flat_ZaFlatTable do databáze vytvořit hlavní objekt (zajemce). 
     * Tak není nutné vytvářej záznam pro objekt zajemce v databázi předem a riskovat vznik záznamu hlavního objektu, ke kterému 
     * nikdy nevzniknou žádná data ve flat tabulce.
     * @param Projektor2_Model_Db_Zajemce $zajemce 
     */
    public function __construct(Projektor2_Model_Db_Zajemce $zajemce=NULL){
        $mainObjectMapperClassName = 'Projektor2_Model_Db_ZajemceMapper';
        if (class_exists($mainObjectMapperClassName)) {
            parent::__construct("za_flat_table",$zajemce, NULL, $mainObjectMapperClassName);
        } else {
            throw new LogicException('Ve třídě '.__CLASS__.'je nastaven neexistující mapper hlavního objektu.');
        }
    }
}
