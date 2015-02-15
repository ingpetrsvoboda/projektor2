document.onkeyup=proces;
document.onmouseup=proces;
document.onmousedown=proces;

function proces()
{

//alert (document.forms[1]['popis_ucastnik_pozaduje_1'].name);    
    
maxdelka=300;
value=document.forms['form_doprk']['popis_ucastnik_pozaduje_1'].value;   
len=maxdelka-value.length;
if(len<0){
 document.forms['form_doprk']['popis_ucastnik_pozaduje_1'].value = document.forms['form_doprk']['popis_ucastnik_pozaduje_1'].value.substring(0,maxdelka);
 alert('Vstup nemůže být delší!');
}

maxdelka=300;
value=document.forms['form_doprk']['popis_poradce_doporucuje_1'].value;
len=maxdelka-value.length;
if(len<0){
 document.forms['form_doprk']['popis_poradce_doporucuje_1'].value = document.forms['form_doprk']['popis_poradce_doporucuje_1'].value.substring(0,maxdelka);
 alert('Vstup nemůže být delší!');
}

maxdelka=300;
value=document.forms['form_doprk']['popis_ucastnik_pozaduje_2'].value;
len=maxdelka-value.length;
if(len<0){
 document.forms['form_doprk']['popis_ucastnik_pozaduje_2'].value = document.forms['form_doprk']['popis_ucastnik_pozaduje_2'].value.substring(0,maxdelka);
 alert('Vstup nemůže být delší!');
}

maxdelka=300;
value=document.forms['form_doprk']['popis_poradce_doporucuje_2'].value;
len=maxdelka-value.length;
if(len<0){
 document.forms['form_doprk']['popis_poradce_doporucuje_2'].value = document.forms['form_doprk']['popis_poradce_doporucuje_2'].value.substring(0,maxdelka);
 alert('Vstup nemůže být delší!');
}


maxdelka=300;
value=document.forms['form_doprk']['popis_ucastnik_pozaduje_3'].value;
len=maxdelka-value.length;
if(len<0){
 document.forms['form_doprk']['popis_ucastnik_pozaduje_3'].value = document.forms['form_doprk']['popis_ucastnik_pozaduje_3'].value.substring(0,maxdelka);
 alert('Vstup nemůže být delší!');
}

maxdelka=300;
value=document.forms['form_doprk']['popis_poradce_doporucuje_3'].value;
len=maxdelka-value.length;
if(len<0){
 document.forms['form_doprk']['popis_poradce_doporucuje_3'].value = document.forms['form_doprk']['popis_poradce_doporucuje_3'].value.substring(0,maxdelka);
 alert('Vstup nemůže být delší!');
}

maxdelka=300;
value=document.forms['form_doprk']['doporuceni_na_doplneni_1'].value;
len=maxdelka-value.length;
if(len<0){
 document.forms['form_doprk']['doporuceni_na_doplneni_1'].value = document.forms['form_doprk']['doporuceni_na_doplneni_1'].value.substring(0,maxdelka);
 alert('Vstup nemůže být delší!');
}


maxdelka=300;
value=document.forms['form_doprk']['doporuceni_na_doplneni_2'].value;
len=maxdelka-value.length;
if(len<0){
 document.forms['form_doprk']['doporuceni_na_doplneni_2'].value = document.forms['form_doprk']['doporuceni_na_doplneni_2'].value.substring(0,maxdelka);
 alert('Vstup nemůže být delší!');
}


maxdelka=300;
value=document.forms['form_doprk']['doporuceni_na_doplneni_3'].value;
len=maxdelka-value.length;
if(len<0){
 document.forms['form_doprk']['doporuceni_na_doplneni_3'].value = document.forms['form_doprk']['doporuceni_na_doplneni_3'].value.substring(0,maxdelka);
 alert('Vstup nemůže být delší!');
}


maxdelka=300;
value=document.forms['form_doprk']['doporuceni_na_doplneni_4'].value;
len=maxdelka-value.length;
if(len<0){
 document.forms['form_doprk']['doporuceni_na_doplneni_4'].value = document.forms['form_doprk']['doporuceni_na_doplneni_4'].value.substring(0,maxdelka);
 alert('Vstup nemůže být delší!');
}


maxdelka=300;
value=document.forms['form_doprk']['doporuceni_na_doplneni_5'].value;
len=maxdelka-value.length;
if(len<0){
 document.forms['form_doprk']['doporuceni_na_doplneni_5'].value = document.forms['form_doprk']['doporuceni_na_doplneni_5'].value.substring(0,maxdelka);
 alert('Vstup nemůže být delší!');
}


maxdelka=300;
value=document.forms['form_doprk']['doporuceni_na_doplneni_6'].value;
len=maxdelka-value.length;
if(len<0){
 document.forms['form_doprk']['doporuceni_na_doplneni_6'].value = document.forms['form_doprk']['doporuceni_na_doplneni_6'].value.substring(0,maxdelka);
 alert('Vstup nemůže být delší!');
}


//alert('Vstup nemůže být delší!');
}


