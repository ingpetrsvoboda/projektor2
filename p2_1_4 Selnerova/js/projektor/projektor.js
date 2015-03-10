/* 
 * drobné js funkce pro projektor
 */

var navratovy_objekt;
function kzam_okno(nova_url, jmeno)
{
    navratovy_objekt = document.getElementById(jmeno);
    window.open(nova_url,'Vyber_kzam');
}

var FullFileName='';
function Zobraz_pdf() {
    if (FullFileName) window.open(FullFileName);
}
