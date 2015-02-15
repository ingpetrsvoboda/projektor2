<?php
class Projektor2_Model_Db_SysUser {
    public $id;
    public $username;
    public $name;
    public $povolen_zapis;
   
   public $tl_spzp_sml;
   public $tl_spzp_dot;
   public $tl_spzp_plan;
   public $tl_spzp_ukon;
   public $tl_spzp_testpc;
   public $tl_spzp_zam;
   public $tl_spzp_dopRK;
   public $tl_spzp_dopRKdoplneni1;
   public $tl_spzp_dopRKdoplneni2;
   public $tl_spzp_dopRKvyrazeni;
   
   public $tl_spzp_agp;
   
   public $tl_rnh_sml;
   public $tl_rnh_dot;
   public $tl_rnh_plan;
   public $tl_rnh_ukon;
   public $tl_rnh_testpc;
   public $tl_rnh_zam;
   public $tl_rnh_dopRK;
   public $tl_rnh_dopRKdoplneni1;
   public $tl_rnh_dopRKdoplneni2;
   public $tl_rnh_dopRKvyrazeni;
   
   public $tl_rnh_agp;
   
   public $tl_agp_sml;
   public $tl_agp_souhlas;
   public $tl_agp_dot;
   public $tl_agp_plan;
   public $tl_agp_ukon;
   public $tl_agp_zam;
   
   public $tl_he_sml;
   public $tl_he_souhlas;
   public $tl_he_dot;
   public $tl_he_plan;
   public $tl_he_ukon;
   public $tl_he_zam;

   public $tl_ap_sml;
   public $tl_ap_souhlas;
   public $tl_ap_dot;
   public $tl_ap_ip1;
   public $tl_ap_plan;
   public $tl_ap_porad;
   public $tl_ap_ukon;
   public $tl_ap_zam;

   public $tl_sj_sml;
   public $tl_sj_souhlas;
   public $tl_sj_dot;
   public $tl_sj_plan;
   public $tl_sj_porad;
   public $tl_sj_ukon;
   public $tl_sj_zam;   

   public function __construct($id =false,$username=false,$name=false, $povolen_zapis=false,
                            $tl_spzp_sml=false,$tl_spzp_dot=false,$tl_spzp_plan=false,$tl_spzp_ukon=false,$tl_spzp_testpc=false,$tl_spzp_zam=false, $tl_spzp_dopRK=false,
                            $tl_spzp_dopRKdoplneni1=false,$tl_spzp_dopRKdoplneni2=false, $tl_spzp_dopRKvyrazeni=false, $tl_spzp_agp=false,
                            $tl_rnh_sml=false,$tl_rnh_dot=false,$tl_rnh_plan=false,$tl_rnh_ukon=false, $tl_rnh_testpc=false, $tl_rnh_zam=false,
                            $tl_rnh_dopRK=false,
                            $tl_rnh_dopRKdoplneni1=false, $tl_rnh_dopRKdoplneni2=false, $tl_rnh_dopRKvyrazeni=false, $tl_rnh_agp=false,
                            $tl_agp_sml=false, $tl_agp_souhlas=false, $tl_agp_dot=false,$tl_agp_plan=false, $tl_agp_ukon=false, $tl_agp_zam=false,
                            $tl_he_sml=false, $tl_he_souhlas=false, $tl_he_dot=false, $tl_he_plan=false, $tl_he_ukon=false, $tl_he_zam=false,
                            $tl_ap_sml=false, $tl_ap_souhlas=false, $tl_ap_dot=false, $tl_ap_ip1=false, $tl_ap_plan=false, $tl_ap_porad=false, $tl_ap_ukon=false, $tl_ap_zam=false,
                            $tl_sj_sml=false, $tl_sj_souhlas=false, $tl_sj_dot=false, $tl_sj_plan=false, $tl_sj_porad=false, $tl_sj_ukon=false, $tl_sj_zam=false
           )
                   {
       
       $this->id = $id;
       $this->username = $username;
       $this->name = $name;
       $this->povolen_zapis = $povolen_zapis;
        
       $this->tl_spzp_sml = $tl_spzp_sml;
       $this->tl_spzp_dot = $tl_spzp_dot;
       $this->tl_spzp_plan = $tl_spzp_plan;
       $this->tl_spzp_ukon = $tl_spzp_ukon;
       $this->tl_spzp_testpc = $tl_spzp_testpc;
       $this->tl_spzp_zam= $tl_spzp_zam;
       $this->tl_spzp_dopRK= $tl_spzp_dopRK;
       $this->tl_spzp_dopRKdoplneni1= $tl_spzp_dopRKdoplneni1;
       $this->tl_spzp_dopRKdoplneni2= $tl_spzp_dopRKdoplneni2;
       $this->tl_spzp_dopRKvyrazeni= $tl_spzp_dopRKvyrazeni; 
       
       $this->tl_spzp_agp= $tl_spzp_agp;
       
       $this->tl_rnh_sml = $tl_rnh_sml;
       $this->tl_rnh_dot = $tl_rnh_dot;
       $this->tl_rnh_plan = $tl_rnh_plan;
       $this->tl_rnh_ukon = $tl_rnh_ukon;
       $this->tl_rnh_testpc = $tl_rnh_testpc;
       $this->tl_rnh_zam= $tl_rnh_zam;
       $this->tl_rnh_dopRK= $tl_rnh_dopRK;
       $this->tl_rnh_dopRKdoplneni1= $tl_rnh_dopRKdoplneni1;
       $this->tl_rnh_dopRKdoplneni2= $tl_rnh_dopRKdoplneni2;
       $this->tl_rnh_dopRKvyrazeni= $tl_rnh_dopRKvyrazeni;
       
       $this->tl_rnh_agp= $tl_rnh_agp;
       
       $this->tl_agp_sml= $tl_agp_sml;
       $this->tl_agp_souhlas= $tl_agp_souhlas;
       $this->tl_agp_dot= $tl_agp_dot;
       $this->tl_agp_plan= $tl_agp_plan;
       $this->tl_agp_ukon= $tl_agp_ukon;
       $this->tl_agp_zam= $tl_agp_zam;
       
       $this->tl_he_sml= $tl_he_sml;
       $this->tl_he_souhlas= $tl_he_souhlas;
       $this->tl_he_dot= $tl_he_dot;
       $this->tl_he_plan= $tl_he_plan;
       $this->tl_he_ukon= $tl_he_ukon;
       $this->tl_he_zam= $tl_he_zam;
       
       $this->tl_ap_sml = $tl_ap_sml;
       $this->tl_ap_souhlas = $tl_ap_souhlas;
       $this->tl_ap_dot = $tl_ap_dot;
       $this->tl_ap_ip1 = $tl_ap_ip1;
       $this->tl_ap_plan = $tl_ap_plan;
       $this->tl_ap_porad = $tl_ap_porad;
       $this->tl_ap_ukon = $tl_ap_ukon;
       $this->tl_ap_zam = $tl_ap_zam;   
       
       $this->tl_sj_dot = $tl_sj_dot;
       $this->tl_sj_sml = $tl_sj_sml;
       $this->tl_sj_souhlas = $tl_sj_souhlas;
       $this->tl_sj_plan = $tl_sj_plan;
       $this->tl_sj_porad = $tl_sj_porad;
       $this->tl_sj_ukon = $tl_sj_ukon;
       $this->tl_sj_zam = $tl_sj_zam;
       
       
                   }
       
}
?>