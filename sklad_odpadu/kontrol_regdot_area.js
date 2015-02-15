document.onkeyup=proces;
document.onmouseup=proces;
document.onmousedown=proces;

function proces()
{
//alert ('AAA');
   
/*alert (document.forms[1]['specializace_v_praxi'].name);*/



maxdelka=360;
value=document.forms['form_dotaznik']['specializace_v_praxi'].value;   
len=maxdelka-value.length;
if(len<0){
 document.forms['form_dotaznik']['specializace_v_praxi'].value = document.forms['form_dotaznik']['specializace_v_praxi'].value.substring(0,maxdelka);
 alert('Vstup nemůže být delší!');
}

maxdelka=360;
value=document.forms['form_dotaznik']['PC_popis'].value;   
len=maxdelka-value.length;
if(len<0){
 document.forms['form_dotaznik']['PC_popis'].value = document.forms['form_dotaznik']['PC_popis'].value.substring(0,maxdelka);
 alert('Vstup nemůže být delší!');
}

maxdelka=230;
value=document.forms['form_dotaznik']['zamestnani_popis1'].value;   
len=maxdelka-value.length;
if(len<0){
 document.forms['form_dotaznik']['zamestnani_popis1'].value = document.forms['form_dotaznik']['zamestnani_popis1'].value.substring(0,maxdelka);
 alert('Vstup nemůže být delší!');
}
maxdelka=230;
value=document.forms['form_dotaznik']['zamestnani_popis2'].value;   
len=maxdelka-value.length;
if(len<0){
 document.forms['form_dotaznik']['zamestnani_popis2'].value = document.forms['form_dotaznik']['zamestnani_popis2'].value.substring(0,maxdelka);
 alert('Vstup nemůže být delší!');
}
maxdelka=230;
value=document.forms['form_dotaznik']['zamestnani_popis3'].value;   
len=maxdelka-value.length;
if(len<0){
 document.forms['form_dotaznik']['zamestnani_popis3'].value = document.forms['form_dotaznik']['zamestnani_popis3'].value.substring(0,maxdelka);
 alert('Vstup nemůže být delší!');
}
maxdelka=230;
value=document.forms['form_dotaznik']['zamestnani_popis4'].value;   
len=maxdelka-value.length;
if(len<0){
 document.forms['form_dotaznik']['zamestnani_popis4'].value = document.forms['form_dotaznik']['zamestnani_popis4'].value.substring(0,maxdelka);
 alert('Vstup nemůže být delší!');
}
maxdelka=230;
value=document.forms['form_dotaznik']['zamestnani_popis5'].value;   
len=maxdelka-value.length;
if(len<0){
 document.forms['form_dotaznik']['zamestnani_popis5'].value = document.forms['form_dotaznik']['zamestnani_popis5'].value.substring(0,maxdelka);
 alert('Vstup nemůže být delší!');
}



maxdelka=300;
value=document.forms['form_dotaznik']['pozadavky_prace'].value;   
len=maxdelka-value.length;
if(len<0){
 document.forms['form_dotaznik']['pozadavky_prace'].value = document.forms['form_dotaznik']['pozadavky_prace'].value.substring(0,maxdelka);
 alert('Vstup nemůže být delší!');
}

//alert('Vstup nemůže být delší!');
}


