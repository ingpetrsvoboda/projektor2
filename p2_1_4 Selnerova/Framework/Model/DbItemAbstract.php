<?php
/**
 * Description of Projektor2_Model_RowModelAbstract
 *
 * @author pes2704
 */
abstract class Framework_Model_DbItemAbstract extends Framework_Model_ItemAbstract  implements Framework_Model_DbItemInterface {
    
    const OBJECT_ID_NAME = 'id';

    private $idName;
    
    public function __construct() {
        $this->idName = self::OBJECT_ID_NAME;
    }
    
    public function getId() {
        $id = $this->idName;
        return $this->$id;
    }
    
    public function getIdName() {
        return $this->idName;
    }
    
    public function setIdName($name) {
        if (!is_string($name)) {
            throw new UnexpectedValueException('Jméno vlastnosti s id objektu musí být řetězec. Zadáno: '.  print_r($name, TRUE));
        }
        $this->idName = $name;
    }
}
