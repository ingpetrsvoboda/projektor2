<?php
/**
 * Emuluje enum typ DbType.
 * Použití:
 * <code>
 * try {
 *     new Framework_Database_DbTypeEnum(Framework_Database_DbTypeEnum::MSSQL);   //OK, vrací hodnotu 'mssql'
 *     new Framework_Database_DbTypeEnum('bla'); // Vyhodí výjimku
 * } catch (UnexpectedValueException $uve) {
 *     echo $uve->getMessage() . PHP_EOL;
 * }
 * </code>
 * @author pes2704
 */
class Framework_Database_DbTypeEnum extends Framework_Type_Enum {    
    const MySQL = 'mysql';
    const MSSQL = 'sqlsrv';
}
