<?php
class Projektor2_Model_Db_Ciselnik {
    private $jmeno_ciselniku;
    public $id;
    
    public function __construct($jmeno_ciselniku=false) {
        $this->jmeno_ciselniku=$jmeno_ciselniku;
    }
    public function check_id($id) {
        $id = trim($id);
        if(strlen($id)==0) {
            $id = "NULL";
        }
        if($id=="NULL") {
            return true;
        }
        if($id) {
            $query="SELECT Count(id_".$this->jmeno_ciselniku.") FROM ".$this->jmeno_ciselniku." WHERE id_".$this->jmeno_ciselniku." = :1";
            $dbh = Projektor2_AppContext::getDb();
            list($pocet) = $dbh->prepare($query)->execute($id)->fetch_row();
            if($pocet) {
                return true;
            }
            return false;
        }    
    }
    public function check_text($text) {
        if($text) {
            $query="SELECT id_".$this->jmeno_ciselniku." AS id FROM ".$this->jmeno_ciselniku." WHERE text LIKE :text";
            $dbh = Projektor2_AppContext::getDb();
            $bindParams = array('text'=>$text);
            $sth = $dbh->prepare($query);
            $succ = $sth->execute($bindParams);
            $data = $sth->fetch(PDO::FETCH_ASSOC);         
            if($data) {
                $this->id=$data['id'];
                return true;
            }
            return false;
        }    
    }
    public function check_column($text,$column) {
        if($text) {
            $query="SELECT id_".$this->jmeno_ciselniku." AS id FROM ".$this->jmeno_ciselniku." WHERE ".$column." LIKE :text";
            $dbh = Projektor2_AppContext::getDb();
            $bindParams = array('text'=>$text);
            $sth = $dbh->prepare($query);
            $succ = $sth->execute($bindParams);
            $data = $sth->fetch(PDO::FETCH_ASSOC);  
            if(!$data) {
                return NULL;
            }             if($data) {
                $this->id=$data['id'];
                return true;
            }
            return false;
        }    
    }
    public function get_value_from_column($id=false,$column="text") {
        if($id) {
            $dbh = Projektor2_AppContext::getDb();
            $query = "SELECT ".$column."
                        FROM ".$this->jmeno_ciselniku."
                        WHERE id_".$this->jmeno_ciselniku." LIKE :id";
            $bindParams = array('id'=>$id);
            $sth = $dbh->prepare($query);
            $succ = $sth->execute($bindParams);
            $data = $sth->fetch(PDO::FETCH_ASSOC);  
            if($data) {
                return $data[0];
            }
        }
        return false;
    }
    
    public static function quickValue($jmenoCiselniku, $id)
    {
    	$ciselnik = new Projektor2_Model_Db_Ciselnik($jmenoCiselniku);
    	return $ciselnik->get_value_from_column($id);
    }
}

?>