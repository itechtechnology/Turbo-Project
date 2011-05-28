<?php
/*
Nome: Converte data
Autor: Marcos Rosa
Criado em: 13/05/11
Modificado por: 
Descrição: Converte uma data e hora no formato 2011-05-13 15:19:51 para 13/05/2011 15:19:51
*/

function converte_data($data){
	
	$dia = $data[8];
	$dia .= $data[9];
	$mes = $data[5];
	$mes .= $data[6];
	$ano = $data[0];
	$ano .= $data[1];
	$ano .= $data[2];
	$ano .= $data[3];
	$hora = $data[11];
	$hora .= $data[12];
	$minuto = $data[14];
	$minuto .= $data[15];
	$segundo = $data[17];
	$segundo .= $data[18];
	
	$data2 = $dia;
	$data2 .= '/'; 
	$data2 .= $mes; 
	$data2 .= '/'; 
	$data2 .= $ano; 
	$data2 .= ' ';
	$data2 .= $hora;
	$data2 .= ':';
	$data2 .= $minuto;
	$data2 .= ':'; 
	$data2 .= $segundo; 
	
	return $data2;
}
?>
