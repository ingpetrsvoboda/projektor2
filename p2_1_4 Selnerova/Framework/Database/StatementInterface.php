<?php 
/**
 * Interface pro třídy vytvářející abstrakci nad databází. Vychází s předpokladu, že PHP PDO + PDOStatement je dobrá abstrakce 
 * nad databází a tento interface spolu s 
 */
interface Framework_Database_StatementInterface {

    public function setFetchMode($fetchMode, $arg2, $arg3);
    public function fetch($fetch_style, $cursor_orientation, $cursor_offset);
    
    public function fetchAll($fetch_style, $fetch_argument, $ctor_args);
    
    public function execute($input_parameters);
}