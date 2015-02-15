<?php
/**
 * Emuluje typ Enum (obdobně jako SplEnum)
 * 
 * Použití:
 * <code>
 * class Framework_DBPDO_DbType extends Framework_Type_Enum { *     
 *     const MySQL = 'mysql';
 *     const MSSQL = 'mssql';
 * }
 * 
 * try {
 *     new DbType(Framework_DBPDO_DbType::MSSQL);   //OK, vrací hodnotu 'mssql'
 *     new DbType('bla'); // Vyhodí výjimku
 * } catch (UnexpectedValueException $uve) {
 *     echo $uve->getMessage() . PHP_EOL;
 * }
 * </code>
 * @author pes2704
 */
abstract class Framework_Type_Enum {
    public function __invoke($name) {
        $fullName = get_called_class().'::'.$name;
        if (constant($fullName)) {
            return constant($fullName);
        } else {
            if (is_scalar($name)) {
                throw new \UnexpectedValueException('Value '.$name.' not a constant in enum '. get_called_class());
            } else {
                throw new \UnexpectedValueException('Value not a constant in enum '. get_called_class());                
            }
        }
    } 
}