<?php
class Projektor2_Datum 
{
    private $den=0;
    private $mesic=0;
    private $rok=0;
    public $ok=false;
    public $notNull=false;
    public $f_mysql = false;
    public $f_web = false;
    
    public function __construct($datum=false,$typ=false) 
    {
        if($datum) 
        {
            if(!$typ) 
            {
                $datum=trim($datum);
                $regex_pattern="^([1-9]|0[0-9]|1[0-9]|2[0-9]|3[0-1])\.( [1-9]|[1-9]|1[0-2]|0[1-9])\.( [1-2][0-9]{3}|[1-2][0-9]{3})";
                if (ereg($regex_pattern, $datum, $regs)) {
                    if(strlen($this->den=trim($regs[1]))==1) {
                        $this->den ="0".$this->den;
                    }
                    if(strlen($this->mesic=trim($regs[2]))==1) {
                        $this->mesic="0".$this->mesic;
                    }
                    $this->rok=trim($regs[3]);
                    if (checkdate($regs[2],$regs[1],$regs[3])) $this->ok=true;
                    $this->notNull=true;
                    $this->f_mysql = $this->rok."-".$this->mesic."-".$this->den;
                    $this->f_web = $this->den.".".$this->mesic.".".$this->rok;
                    return;
            	}
            } else {
            	switch($typ) {
                	case "MySQL":
                    	$datum_array=explode("-",$datum);
                    	$this->rok=$datum_array[0];
                    	$this->mesic=$datum_array[1];
                    	$this->den=$datum_array[2];
                    	$this->ok=true;
                        $this->notNull=true;
                    	$this->f_mysql = $this->rok."-".$this->mesic."-".$this->den;
                    	$this->f_web = $this->den.".".$this->mesic.".".$this->rok;
                    	return;
             	}
            }
        } else {
            if($datum =="") {
                $this->f_mysql = "NULL";
                $this->ok=true;
                $this->notNull=false;
                return;
            }
        }
        
        $this->ok=false;
    }

}
?>