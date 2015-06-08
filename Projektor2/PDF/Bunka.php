<?php
class Projektor2_PDF_Bunka
{
	public $sirka;
	public $vyska;
	public $textUTF8;
	public $promennaUTF8;
	public $ohraniceni;
	public $odradkovani;
	public $zarovnani;
	public $vypln;
	public $id;
	public $debugPrazdna;

	/**
	 * Vytvoří objekt Bunka obsahující text $textUTF8 a string hodnotu $promennaUTF8 a formátování
	 * @param real $sirka
	 * @param real $vyska
	 * @param string $textUTF8
	 * @param string $promennaUTF8
	 * @param integer $ohraniceni
	 * @param boolean $odradkovani
	 * @param character $zarovnani
	 * @param boolean $vypln
	 * @param string $link
	 * @param integer $id
	 * @return Bunka
	 */
	public function __construct($id, $sirka=false, $vyska=false, $textUTF8='', $promennaUTF8=false, $ohraniceni=0, $odradkovani=0, $zarovnani='', $vypln=false, $link='')
	{
		$this->id = $id;
		$this->sirka = $sirka;
		$this->vyska = $vyska;
		$this->textUTF8 = $textUTF8;
		$this->promennaUTF8 = $promennaUTF8;
		$this->ohraniceni = $ohraniceni;
		$this->odradkovani = $odradkovani;
		$this->zarovnani = $zarovnani;
		$this->vypln = $vypln;
		$this->debugPrazdna = "prazdna";
	}
        
        public function setSirka($sirka) {
            $this->sirka = $sirka;
        }

        public function setVyska($vyska) {
            $this->vyska = $vyska;
        }
        
        public function setTextUTF8($textUTF8) {
		$this->textUTF8 = $textUTF8;
        }
        
        public function setPromennaUTF8($promennaUTF8) {
            $this->promennaUTF8 = $promennaUTF8;
        }
        
        public function setOhraniceni($ohraniceni) {
		$this->ohraniceni = $ohraniceni;
        }
        
        public function setOdradkovani($odradkovani) {
            $this->odradkovani = $odradkovani;
        }
        
        public function setZarovnani($zarovnani) {
            $this->zarovnani = $zarovnani;
        }
        
        public function setVypln($vypln) {
            $this->vypln = $vypln;
        }       
    }
