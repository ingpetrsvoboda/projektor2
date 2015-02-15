document.onkeyup=proces;
document.onmouseup=proces;
document.onmousedown=proces;

function proces()
{
//alert ('AAA');
   
/*alert (document.forms[1]['specializace_v_praxi'].name);*/



maxdelka=500;
value=document.forms['form_ukonc']['mot_hodnoceni'].value;   
len=maxdelka-value.length;
if(len<0){
 document.forms['form_ukonc']['mot_hodnoceni'].value = document.forms['form_ukonc']['mot_hodnoceni'].value.substring(0,maxdelka);
 alert('Vstup nemůže být delší!');
}

maxdelka=500;
value=document.forms['form_ukonc']['pc1_hodnoceni'].value;   
len=maxdelka-value.length;
if(len<0){
 document.forms['form_ukonc']['pc1_hodnoceni'].value = document.forms['form_ukonc']['pc1_hodnoceni'].value.substring(0,maxdelka);
 alert('Vstup nemůže být delší!');
}


maxdelka=500;
value=document.forms['form_ukonc']['pc2_hodnoceni'].value;   
len=maxdelka-value.length;
if(len<0){
 document.forms['form_ukonc']['pc2_hodnoceni'].value = document.forms['form_ukonc']['pc2_hodnoceni'].value.substring(0,maxdelka);
 alert('Vstup nemůže být delší!');
}



maxdelka=500;
value=document.forms['form_ukonc']['bidi_hodnoceni'].value;   
len=maxdelka-value.length;
if(len<0){
 document.forms['form_ukonc']['bidi_hodnoceni'].value = document.forms['form_ukonc']['bidi_hodnoceni'].value.substring(0,maxdelka);
 alert('Vstup nemůže být delší!');
}

maxdelka=500;
value=document.forms['form_ukonc']['prdi_hodnoceni'].value;   
len=maxdelka-value.length;
if(len<0){
 document.forms['form_ukonc']['prdi_hodnoceni'].value = document.forms['form_ukonc']['prdi_hodnoceni'].value.substring(0,maxdelka);
 alert('Vstup nemůže být delší!');
}

maxdelka=500;
value=document.forms['form_ukonc']['praxe_hodnoceni'].value;   
len=maxdelka-value.length;
if(len<0){
 document.forms['form_ukonc']['praxe_hodnoceni'].value = document.forms['form_ukonc']['praxe_hodnoceni'].value.substring(0,maxdelka);
 alert('Vstup nemůže být delší!');
}


maxdelka=500;
value=document.forms['form_ukonc']['prof1_hodnoceni'].value;   
len=maxdelka-value.length;
if(len<0){
 document.forms['form_ukonc']['prof1_hodnoceni'].value = document.forms['form_ukonc']['prof1_hodnoceni'].value.substring(0,maxdelka);
 alert('Vstup nemůže být delší!');
}


maxdelka=500;
value=document.forms['form_ukonc']['prof2_hodnoceni'].value;   
len=maxdelka-value.length;
if(len<0){
 document.forms['form_ukonc']['prof2_hodnoceni'].value = document.forms['form_ukonc']['prof2_hodnoceni'].value.substring(0,maxdelka);
 alert('Vstup nemůže být delší!');
}

maxdelka=500;
value=document.forms['form_ukonc']['prof3_hodnoceni'].value;   
len=maxdelka-value.length;
if(len<0){
 document.forms['form_ukonc']['prof3_hodnoceni'].value = document.forms['form_ukonc']['prof3_hodnoceni'].value.substring(0,maxdelka);
 alert('Vstup nemůže být delší!');
}




maxdelka=500;
value=document.forms['form_ukonc']['porad_hodnoceni'].value;   
len=maxdelka-value.length;
if(len<0){
 document.forms['form_ukonc']['porad_hodnoceni'].value = document.forms['form_ukonc']['porad_hodnoceni'].value.substring(0,maxdelka);
 alert('Vstup nemůže být delší!');
}


maxdelka=500;
value=document.forms['form_ukonc']['doporuceni'].value;   
len=maxdelka-value.length;
if(len<0){
 document.forms['form_ukonc']['doporuceni'].value = document.forms['form_ukonc']['doporuceni'].value.substring(0,maxdelka);
 alert('Vstup nemůže být delší!');
}


maxdelka=500;
value=document.forms['form_ukonc']['vyhodnoceni'].value;   
len=maxdelka-value.length;
if(len<0){
 document.forms['form_ukonc']['vyhodnoceni'].value = document.forms['form_ukonc']['vyhodnoceni'].value.substring(0,maxdelka);
 alert('Vstup nemůže být delší!');
}


//alert('Vstup nemůže být delší!');
}


