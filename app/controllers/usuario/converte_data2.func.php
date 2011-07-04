<?php
/*
Nome: Converte data 2
Autor: Marcos Rosa
Criado em: 13/05/11
Modificado por: 
Descrição: Converte uma data e hora no formato 13/05/2011 15:19:51 para 2011-05-13 15:19:51 
*/

function converte_data2($data){
	
	$dia = $data[0];
	$dia .= $data[1];
	$mes = $data[3];
	$mes .= $data[4];
	$ano = $data[6];
	$ano .= $data[7];
	$ano .= $data[8];
	$ano .= $data[9];
	$hora = $data[11];
	$hora .= $data[12];
	$minuto = $data[14];
	$minuto .= $data[15];
	$segundo = $data[17];
	$segundo .= $data[18];
	
	$data2 = $ano;
	$data2 .= '-'; 
	$data2 .= $mes; 
	$data2 .= '-'; 
	$data2 .= $dia; 
	$data2 .= ' ';
	$data2 .= $hora;
	$data2 .= ':';
	$data2 .= $minuto;
	$data2 .= ':'; 
	$data2 .= $segundo; 
	
	return $data2;
}
?>
