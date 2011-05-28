<?php
/*
Nome: Função valida data 1.1
Autor: Marcos Rosa
Criado em: 07/05/11
Modificado por: Marcos Rosa em 08/05/11
Descrição: Retorna FALSE se uma data não for válida e TRUE se for válida
*/
function valida_data($data){
	
		$i = 0;
		$dia = NULL;
		$mes = NULL;
		$ano = NULL;
		
		$tamanho = strlen($data);
		while($i<$tamanho){//Separa dia, mês e ano do formato dd/mm/aaaa
			if(($i==0)||($i==1)) $dia .= $data[$i];
			if(($i==3)||($i==4)) $mes .= $data[$i];
			if(($i==6)||($i==7) ||($i==8) ||($i==9)) $ano .= $data[$i]; 
			$i++;
		}
		
		if ($tamanho != 10) return FALSE;//Caso não esteja no formato dd/mm/aaaa
		if (($ano < 1900)||($ano > 2011)) return FALSE; //Alterar para pegar o ano do sistema
		if (($mes < 1)||($mes > 12)) return FALSE;
		if (($dia < 1)||($dia > 31)) return FALSE;
		
		switch ($mes) {
                                
             case "04":              
             case "06":
             case "09":
             case "11":
             	if  ($dia > 30) return FALSE; //Meses: 4,6,9 e 11 têm 30 dias                           
			 break;
                                        
             case "02"://Valida mês de fervereiro com anos bissextos
                if (($ano % 4 == 0) || ($ano % 100 == 0) || ($ano % 400 == 0)) $bissexto = 1;
                if (($bissexto == 1) && ($dia > 29)) return FALSE;                             
				if (($bissexto != 1) && ($dia > 28)) return FALSE; 
             break;
		}                   

		return TRUE; //Se tudo estiver correto
}	
?>