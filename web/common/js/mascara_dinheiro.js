// ------------------------------------------------------------------------------------------ //
// Verificar qual navegador
// ------------------------------------------------------------------------------------------ //
function QualNavegador(){
	var u = navigator.userAgent.toLowerCase();
	var s = navigator.appName;	
	if(u.indexOf('safari')!= -1)
		return "SA";	
	if ( s == "Microsoft Internet Explorer" )
		return "IE";
	else if ( s == "Netscape" )
		return "NE";
	else
		return "";
}


// ------------------------------------------------------------------------------------------ //
// Verificar qual a versão do navegador
// ------------------------------------------------------------------------------------------ //
function QualVersao()
{
	var s = navigator.appVersion;
	if ( QualNavegador() == "IE" )
	{
		var i = s.search("MSIE");
		s=s.substring(i+5);
		i=s.search(";");
		return s.substring(0,i);
	}
	else if ( QualNavegador() == "NE" ){
		if(navigator.userAgent.indexOf('Netscape/7.0')!= -1)return "7.0";		
		if(navigator.userAgent.indexOf('Netscape/7.1')!= -1)return "7.1";
		return parseInt(s.substring(0,1));
	}
	else{
		return 0;}
}

// ------------------------------------------------------------------------------------------ //
// Verificar se é Macintosh
// ------------------------------------------------------------------------------------------ //
function SeMac(){
	var s = navigator.appVersion;
	var v = s.search("Mac");  

	if (v!=-1){
		return "MAC";
	}
	return 0;
}


// ------------------------------------------------------------------------------------------ //
// Função   : Formata
// ------------------------------------------------------------------------------------------ //

function Formata(campo,tammax,teclapres,decimal) { 
  var tecla = teclapres.keyCode; 
  vr 	    = Limpar(campo.value,"0123456789"); 
  tam	    = vr.length; 
  dec	    = decimal 


if(tam < tammax && tecla != 8){ 
  tam = vr.length + 1; 
} 

if(tecla == 8 ) { 
  tam = tam - 1 ; 
} 

if( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 ) { 
 if ( tam <= dec ){
   campo.value = vr;
 } 

 if( (tam > dec) && (tam <= 5) ){ 
   campo.value = vr.substr( 0, tam - 2 ) + "," + vr.substr( tam - dec, tam );
 } 

 if( (tam >= 6) && (tam <= 8) ){  
   campo.value = vr.substr( 0, tam - 5 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ); 
 } 

 if( (tam >= 9) && (tam <= 11) ){ 
   campo.value = vr.substr( 0, tam - 8 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; 
 }
 
 if( (tam >= 12) && (tam <= 14) ){ 
    campo.value = vr.substr( 0, tam - 11 ) + "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam );
 }
 
  if ( (tam >= 15) && (tam <= 17) ){  
    campo.value = vr.substr( 0, tam - 14 ) + "." + vr.substr( tam - 14, 3 ) + "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - 2, tam );
  } 
 } 
} 


// ------------------------------------------------------------------------------------------ //
// Função   : Limpar
// ------------------------------------------------------------------------------------------ //
function Limpar(valor, validos) { 
  // retira caracteres invalidos da string 
  var result = ""; 
  var aux; 
  for (var i=0; i < valor.length; i++) { 
   aux = validos.indexOf(valor.substring(i, i+1)); 
   if (aux>=0) { 
     result += aux; 
   } 
 } 
  return result; 
} 



// ------------------------------------------------------------------------------------------ //
// Função   : FormataTotal
// ------------------------------------------------------------------------------------------ //

function FormataTotal(campo,tammax,decimal) { 
  vr 	    = Limpar(campo,"0123456789"); 
  tam	    = vr.length; 
  dec	    = decimal;
  

 if ( tam <= dec ){
   campo = vr;
 } 

 if( (tam > dec) && (tam <= 5) ){ 
   campo = vr.substr( 0, tam - 2 ) + "," + vr.substr( tam - dec, tam );
 } 

 if( (tam >= 6) && (tam <= 8) ){  
   campo = vr.substr( 0, tam - 5 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ); 
 } 

 if( (tam >= 9) && (tam <= 11) ){ 
   campo = vr.substr( 0, tam - 8 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; 
 }
 
 if( (tam >= 12) && (tam <= 14) ){ 
    campo = vr.substr( 0, tam - 11 ) + "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam );
 }
 
  if ( (tam >= 15) && (tam 