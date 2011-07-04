/*
===================================================================
FUNÇÃO QUE VERIFICA SE O CPF É VALIDO
FUNÇÃO QUE VERIFICA SE O CNPJ É VALIDO
FUNÇÃO QUE FORMATA CPF
FUNÇÃO QUE FORMATA CNPJ
FUNÇÃO QUE PREENCHE COM ZERO A ESQUERDA
====================================================================

DESENVOLVEDOR: GREICY LUCIANA

====================================================================
DEVEM SER USADOS DA SEGUINTE FORMA:

onKeyPress="ValidaNumerico4(event.keyCode); this.value=f_sMascaraCpf(this.value)" onBlur="s_validaCPF(this)"

===================================================================
*/
function ValidaCPF(numero)
{
dig_1 = 0;
dig_2 = 0;
controle_1 = 10;
controle_2 = 11;
lsucesso = 1;

if ((numero.length != 12) || (numero.substring(9, 10) != "-"))
{
alert("CPF inválido! Formato: xxxxxxxxx-xx");
return false;
}
else
{
for (i=0 ; i < 9 ; i++)
{
dig_1 = dig_1 + parseInt(numero.substring(i, i+1) * controle_1);
controle_1 = controle_1 - 1;
}

resto = dig_1 % 11;
dig_1 = 11 - resto;

if ((resto == 0) || (resto == 1))
dig_1 = 0;

for ( i=0 ; i < 9 ; i++)
{
dig_2 = dig_2 + parseInt(numero.substring(i, i + 1) * controle_2);
controle_2 = controle_2 - 1;
}

dig_2 = dig_2 + 2 * dig_1;
resto = dig_2 % 11;
dig_2 = 11 - resto;

if ((resto == 0) || (resto == 1))
dig_2 = 0;

dig_ver = (dig_1 * 10) + dig_2;

if (dig_ver != parseFloat(numero.substring(numero.length-2,numero.length)))
{
alert("CPF inválido!");
return false;
}
}
return true;
} 
function f_sMascaraCpf1(sValor){
	switch (sValor.length){
		case 3:
		case 7:
			//sValor = sValor + ".";
			break;
		case 9:
			sValor = sValor + "-";
			break;
	}
	return sValor;
}
function mascara_cnpj(campo) {
	if (campo.value.length == 2)
	{ campo.value += "."; }
	if (campo.value.length == 6)
	{ campo.value += "."; }
	if (campo.value.length == 10)
	{ campo.value += "/"; }
	if (campo.value.length == 15)
	{ campo.value += "-"; }
}
function FormataCNPJ(Campo) {
	var Auxiliar = "";
	Auxiliar += Campo.substring(0, 2);
	Auxiliar += ".";
	Auxiliar += Campo.substring(2, 5);
	Auxiliar += ".";
	Auxiliar += Campo.substring(5, 8);
	Auxiliar += "/";
	Auxiliar += Campo.substring(8, 12);
	Auxiliar += "-";
	Auxiliar += Campo.substring(12, 14);
	return Auxiliar;
}
//:::: Função para verificar se o campo é DATA  DD/MM/AA::::::::::::::::::::::::::::::::::::::::  
	function ValidaNumerico3(Valor)
	{
		if((Valor<48)||(Valor>57)&&(Valor!=44)){
			event.keyCode=0;
		}
	}

//:::: Função para verificar codigos CPF::::::::::::::::::::::::::::::::::::::::  
	function ValidaNumerico4(Valor){
		if (Valor!=null){
			if ((Valor >= 48 && Valor 