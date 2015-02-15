<?php
class Projektor2_Date
{
    /**
     * @var DateTime 
     */
    private $dateTime;

    const SQL_FORMAT = "Y-m-d";
    const STRING_FORMAT = "d.m.Y";

    private function __construct(DateTime $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    /**
     * 
     * @return \self
     */
    public static function now() {
        return new self(new DateTime("now"));  
    }
    
    /**
     * 
     * @param string $retezecDatum
     * @return \self
     */
    public static function zRetezce($retezecDatum=false) 
    {
        $retezecDatum=trim($retezecDatum);
//        $regex_pattern="^([1-9]|0[0-9]|1[0-9]|2[0-9]|3[0-1])\.( [1-9]|[1-9]|1[0-2]|0[1-9])\.( [1-2][0-9]{3}|[1-2][0-9]{3})";
//        if (ereg($regex_pattern, $retezecDatum, $regs) && checkdate($regs[2],$regs[1],$regs[3]))   // SVOBODA This function has been DEPRECATED as of PHP 5.3.0. Relying on this feature is highly discouraged.
        //preg_match()
        $regex_pattern="/^([1-9]|0[0-9]|1[0-9]|2[0-9]|3[0-1])\.( [1-9]|[1-9]|1[0-2]|0[1-9])\.( [1-2][0-9]{3}|[1-2][0-9]{3})/";
        if(preg_match($regex_pattern, $retezecDatum, $regs) && checkdate($regs[2],$regs[1],$regs[3]))
        {        
            $datum = DateTime::createFromFormat(self::SQL_FORMAT, trim($regs[3])."-".trim($regs[2])."-".trim($regs[1]));
            return $datum ? new self($datum) : NULL;
        }
    }

    /**
     * 
     * @param type $sqlDatum
     * @return \self
     */
    public static function zSQL($sqlDatum)
    {
        $datum = DateTime::createFromFormat(self::SQL_FORMAT, $sqlDatum);
        return $datum ? new self($datum) : NULL;
    }

    /**
     * 
     * @param type $pole
     * @return \self
     */
    public static function zQuickForm($pole)
    {
        $datum = DateTime::createFromFormat(self::SQL_FORMAT, $pole["Y"]."-".$pole["m"]."-".$pole["d"]);
        return $datum ? new self($datum) : NULL;
    }

    /**
     * 
     * @return DateTime
     */
    public function dejDateTime()
    {
        return $this->dateTime();
    }

    /**
     * 
     * @return array
     */
    public function dejDatumForm()
    {
        return array("Y" => $this->dateTime->format("Y"), "m" => $this->dateTime->format("m"), "d" => $this->dateTime->format("d"));
    }

    /**
     * 
     * @return string
     */
    public function dejDatumproSQL()
    {
        return $this->dateTime->format(self::SQL_FORMAT);
    }

    /**
     * 
     * @return string
     */
    public function dejDatumRetezec() {
        return $this->dateTime->format(self::STRING_FORMAT);
    }
    
    /**
     * 
     * @return string
     */
    public function dejRokRetezec() {
        return $this->dateTime->format('Y');        
    }
}