<?php
/*
Nome: Função valida e-mail 1.1
Autor: Marcos Rosa
Criado em: 07/05/11
Modificado por: Marcos Rosa em 08/05/11
Descrição: Retorna FALSE se o e-mail não for válido e TRUE se for válido
*/
function valida_email($email){
	
	$i = 0;
	$cont = 0;
	$teste1 = false;
	$teste2 = false;
	$tamanho = strlen($email);
	while($i<$tamanho){
		if ($email[$i] == '@') $teste1 = true; //Verifica se existe um @
		if ($email[$i] == '.') $teste2 = true; //Verifica se existe um ponto
		$cont++; 
		$i++;
	}
	
	if(($teste1 == false)||($cont<=10)||($teste2 == false)) return false;
	return true;	 
	
}
?>