<?php

function zalohuj($db,$soubor=""){
 
  function keys($prefix,$array){
    $pocet = count($array);
    if($pocet == 0)
      return;
    for($i = 0; $i<$pocet; $i++)
      $radky .= "`".$array[$i]."`".($i != $pocet-1 ? ",":"");
    return ",\n".$prefix."(".$radky.")";
  }
 
  $sql = mysql_query("SHOW table status FROM ".$db);
 
 
  while($data = mysql_fetch_row($sql)){
 
    $text .= (empty($text)?"":"\n\n")."--\n-- Struktura tabulky ".$data[0]."\n--\n\n\n";
    $text .= "CREATE TABLE `".$data[0]."`(\n";
    $sqll = mysql_query("SHOW columns FROM ".$data[0]);
    $e = true;
    
    while($dataa = mysql_fetch_row($sqll)){
      if($e) $e = false;
      else $text .= ",\n";
        
      $null = ($dataa[2] == "NO")? "NOT NULL":"NULL";
      $default = !empty($dataa[4])? " DEFAULT '".$dataa[4]."'":"";
      
 
      if($default == " DEFAULT 'CURRENT_TIMESTAMP'") $default = " DEFAULT CURRENT_TIMESTAMP";
      if($dataa[3] == "PRI") $PRI[] = $dataa[0];
      if($dataa[3] == "UNI") $UNI[] = $dataa[0];
      if($dataa[3] == "MUL") $MUL[] = $dataa[0];
      $extra = !empty($dataa[5])? " ".$dataa[5]:"";
      $text .= "`$dataa[0]` $dataa[1] $null$default$extra";
    }
    $primary = keys("PRIMARY KEY",$PRI);
    $unique = keys("UNIQUE KEY",$UNI);
    $mul = keys("INDEX",$MUL);
    $text .= $primary.$unique.$mul."\n) ENGINE=".$data[1]." COLLATE=".$data[14].";\n\n";
    unset($PRI,$UNI,$MUL);
 
    $text .= "--\n-- Data tabulky ".$data[0]."\n--\n\n";
    $query = mysql_query("SELECT * FROM ".$data[0]."");
    while($fetch = mysql_fetch_row($query)){
      $pocet_sloupcu = count($fetch);
      
      for($i = 0;$i < $pocet_sloupcu;$i++)
        $values .= "'".mysql_escape_string($fetch[$i])."'".($i < $pocet_sloupcu-1?",":"");
      $text .= "\nINSERT INTO `".$data[0]."` VALUES(".$values.");";
      unset($values);
    }
  }
 
  if(!empty($soubor)){
    $fp = @fopen($soubor,"w+");
    $fw = @fwrite($fp,$text);
    @fclose($fp);
  }
  
  return $text;
}
 
$hostiteldb="***";
$jmenodb="***";
$heslodb="***";
$db="***";
 
mysql_connect($hostiteldb, $jmenodb, $heslodb);
mysql_query("SET NAMES 'utf8'");
mysql_select_db($db);
 
zalohuj($db,"zalohy/zaloha_mysql".date("-d-m-Y").".sql");
