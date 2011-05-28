<?php

 

//CLASSE PARA MANIPULAR E VALIDAR STRINGS, DATAS, ETC...



class Lib

{



    /**

    * Gera senha

    */

    static public function generate_password($length = 15, $uppercase = false, $lowercase = true, $numbers = true, $codes = false) {

		$maius = "ABCDEFGHIJKLMNOPQRSTUWXYZ";

		$minus = "abcdefghijklmnopqrstuwxyz";

		$numer = "0123456789";

		$codig = '!@#$%&*()-+.,;?{[}]^><:|';

		$base  = '';

		$base .= ($uppercase) ? $maius : '';

		$base .= ($lowercase) ? $minus : '';

		$base .= ($numbers) ? $numer : '';

		$base .= ($codes) ? $codig : '';

		srand((float) microtime() * 10000000);

		$password = '';

		for ($i = 0; $i < $length; $i++) {

			$password .= substr($base, rand(0, strlen($base)-1), 1);

		}

		return $password;

	}



    /**

    * Gera chave de ativação

    */

    static public function keyActivation()

    {

	$code = time();

	$value = 'abcdefghijklmnopqrstuvxz0123456789';

	$total = count($value);

	$c = 0;

	while($c < 20) {

		$code .= rand(0, $total);

		$c++;

	}

	return md5($code);

    }





    static public function charset($str)

    {

	$str = mb_detect_encoding($str.'a' , 'UTF-8, ISO-8859-1');

	return $str;

    }



    static public function convert($str, $default = 'UTF-8')

    {

	switch($default)

        {

            case 'UTF-8' :

		if (self::charset($str) != $default)

                {

                    $str = utf8_encode($str);

		}

                break;

            case 'ISO-8859-1' :

		if (self::charset($str) != $default)

                {

                    $str = utf8_decode($str);

		}

                break;

	}

	return $str;

    }



    static public function toIso($str)

    {

        if (self::charset($str) != 'ISO-8859-1')

        {

            $str = utf8_decode($str);

	}

	return $str;

    }



    static public function remove_accents($str)

    {

        $str 	= self::convert($str, 'ISO-8859-1');

	$from 	= self::convert('ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr', 'ISO-8859-1');

	$to 	= self::convert('AAAAAAACEEEEIIIIDNOOOOOOUUUUYbBaaaaaaaceeeeiiiidnoooooouuuyybyRr', 'ISO-8859-1');

	$str	= strtr($str, $from, $to);

	$str 	= self::convert($str);

	return	$str;

    }



    /*=================================

     *       FUNÇÕES DE SEGURANÇA

    ==================================*/



    // Verifica e filtra tags html

    public function verificar($variavel)

    {

        $variavel = mysql_escape_string($variavel); // strings

                $variavel = str_replace("<html>","",$variavel); // previne html

                $variavel = str_replace("<script","",$variavel); // previne javascript

                $variavel = str_replace("href=","",$variavel); // previne links



        return $variavel;

    }

        

    // Verifica sql injection no codigo.

    function antiInjection($string)

    {

                $string = preg_replace(@sql_regcase("/(from|select|insert|delete|update|where|drop table|drop database|show tables|create|alter table|#|\*|--|\\\\)/"),"",$string);

                $string = strip_tags($string);//tira tags html e php

                $string = addslashes($string);//Adiciona barras invertidas a uma string

                

                return $string;

    }

        

    // Foramata String

    public function formatarString($palavra)

    {

       $palavra_formatada = trim($palavra);

       //$palavra_formatada = strtolower($palavra_formatada);

       $palavra_formatada = $this->antiInjection($palavra_formatada);



       return $palavra_formatada;

    }



    /*=================================

     * FIM - FUNÇÕES DE SEGURANÇA

     =================================*/



    public function formatarNome($nome)

    {

       $nome=trim(strtolower($nome));

           $partes= explode(" ",$nome);



       for ($x=0;$x<count($partes);$x++)

       {

              if (($partes[$x] == "da") || ($partes[$x] == "de") ||($partes[$x]=="dos")){

                     continue;

                  }



          $partes[$x] = ucfirst($partes[$x]);

           }



       $final = implode(" ",$partes);



       return $final;

    }



    // Verifica se string é data no formato brasileiro

    static function isDate ($date)

    {

    	return ereg('^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$', $date);

    }



    // Verifica se string é data no formato internacional

    static function isDateDB ($date)

    {

    	return ereg('^[0-9]{4}\/[0-9]{2}\/[0-9]{2}$', $date);

    }



    // Converte data do formato BR para US

    public function converterDataToUs($data)

    {

       $dia = substr($data,0,2);

       $mes = substr($data,3,2);

       $ano = substr($data,6,4);



       return "{$ano}-{$mes}-{$dia}";

    }



    // Converte data do formato US para BR

    public function converterDataToBr($data)

    {

       $dia = substr($data,8,4);

       $mes = substr($data,5,2);

       $ano = substr($data,0,4);



       return "{$dia}/{$mes}/{$ano}";

    }

        

    public function conveterDataToBrInvertido($data)

    {

       $dia = substr($data,0,2);

       $mes = substr($data,3,2);

       $ano = substr($data,6,4);



       return "{$mes}/{$dia}/{$ano}";

    }



    public function validarCpfCnpj($numero,$tipo)

    {

        // f = f�sica CPF

        // j = juridica CNPJ



        if($tipo == "f")

        {

           $tam_cpf = strlen($numero);



           for ($i=0; $i<$tam_cpf; $i++)

           {

              $carac = substr($numero, $i, 1);

              // verifica se o codigo asc refere-se a 0-9

              if (ord($carac)>=48 && ord($carac)<=57)

                  $cpf_limpo .= $carac;

           }



           if (strlen($cpf_limpo)!=11)

              return false;



           // achar o primeiro digito verificador

           $soma = 0;



           for ($i=0; $i<9; $i++)

             $soma += (int)substr($cpf_limpo, $i, 1) * (10-$i);



           if ($soma == 0)

             return false;



           $primeiro_digito = 11 - $soma % 11;



           if ($primeiro_digito > 9)

              $primeiro_digito = 0;



           if (substr($cpf_limpo, 9, 1) != $primeiro_digito)

              return false;



           // acha o segundo digito verificador

           $soma = 0;



           for ($i=0; $i<10; $i++)

             $soma += (int)substr($cpf_limpo, $i, 1) * (11-$i);



           $segundo_digito = 11 - $soma % 11;



           if ($segundo_digito > 9)

              $segundo_digito = 0;



           if (substr($cpf_limpo, 10, 1) != $segundo_digito)

              return false;



           return true;

        }



      if($tipo == "j")

      {

         if (strlen($numero) <> 14)

            return false;



          $soma = 0;



          $soma += ($numero[0] * 5);

          $soma += ($numero[1] * 4);

          $soma += ($numero[2] * 3);

          $soma += ($numero[3] * 2);

          $soma += ($numero[4] * 9);

          $soma += ($numero[5] * 8);

          $soma += ($numero[6] * 7);

          $soma += ($numero[7] * 6);

          $soma += ($numero[8] * 5);

          $soma += ($numero[9] * 4);

          $soma += ($numero[10] * 3);

          $soma += ($numero[11] * 2);



          $d1 = $soma % 11;

          $d1 = $d1 < 2 ? 0 : 11 - $d1;



          $soma = 0;

          $soma += ($numero[0] * 6);

          $soma += ($numero[1] * 5);

          $soma += ($numero[2] * 4);

          $soma += ($numero[3] * 3);

          $soma += ($numero[4] * 2);

          $soma += ($numero[5] * 9);

          $soma += ($numero[6] * 8);

          $soma += ($numero[7] * 7);

          $soma += ($numero[8] * 6);

          $soma += ($numero[9] * 5);

          $soma += ($numero[10] * 4);

          $soma += ($numero[11] * 3);

          $soma += ($numero[12] * 2);



          $d2 = $soma % 11;

          $d2 = $d2 < 2 ? 0 : 11 - $d2;



          if ($numero[12] == $d1 && $numero[13] == $d2) {

            return true;

          }

          else {

            return false;

          }

        }

    }



    public function crossUrlDecode($source)

    {

      $decodedStr = '';

      $pos = 0;

      $len = strlen($source);



      while ($pos < $len) {

        $charAt = substr ($source, $pos, 1);

        if ($charAt == '?') {

          $char2 = substr($source, $pos, 2);

          $decodedStr .= htmlentities(utf8_decode($char2),ENT_QUOTES,'ISO-8859-1');

          $pos += 2;

        } elseif(ord($charAt) > 127) {

          $decodedStr .= "&#".ord($charAt).";";

          $pos++;

        } elseif($charAt == '%') {

          $pos++;

          $hex2 = substr($source, $pos, 2);

          $dechex = chr(hexdec($hex2));

          if($dechex == '?') {

            $pos += 2;

            if(substr($source, $pos, 1) == '%') {

              $pos++;

              $char2a = chr(hexdec(substr($source, $pos, 2)));

              $decodedStr .= htmlentities(utf8_decode($dechex . $char2a),ENT_QUOTES,'ISO-8859-1');

            } else {

              $decodedStr .= htmlentities(utf8_decode($dechex));

            }

          } else {

            $decodedStr .= $dechex;

          }

          $pos += 2;

        } else {

          $decodedStr .= $charAt;

          $pos++;

        }

      }



      return $decodedStr;

    }



    public function retornarMes($mes)

    {



      switch($mes)

      {



                case "1":



                return $mes_port = "Janeiro";

                break;



                case "2":



                return $mes_port = "Fevereiro";

                break;



                case "3":



                return $mes_port = "Mar�o";

                break;



                case "4":



                return $mes_port = "Abril";

                break;



                case "5":



                return $mes_port = "Maio";

                break;



                case "6":



                return $mes_port = "Junho";

                break;



                case "7":



                return $mes_port = "Julho";

                break;



                case "8":



                return $mes_port = "Agosto";

                break;



                case "9":



                return $mes_port = "Setembro";

                break;



                case "10":



                return $mes_port = "Outubro";

                break;



                case "11":



                return $mes_port = "Novembro";

                break;



                case "12":



                return $mes_port = "Dezembro";

        break;

      }

    }

        

    public function numeroMeses($dias)

    {

                 

                $div = $dias % 30;



                if($div == 0){

                  $div = $dias / 30;

                } else {

                  $div = round($dias / 30);

                }



                return $div;

    }

        

    public function subtrairDatas($dataInicial,$dataFinal)

    {

                /*

                        RETORNA O N�MERO DE DIAS ENTRE AS DATAS INFORMADAS

                */

                

                $auxInicial = strtotime($this->conveterDataToBrInvertido($dataInicial));

                $auxFinal  = strtotime($this->conveterDataToBrInvertido($dataFinal));

                

                $intervalo = ($auxFinal - $auxInicial) / 86400;  

                $intervalo = round($intervalo);

                

                if($intervalo == '0')

                {

                        return '1';

                } else

                {

                        return $intervalo;

                }

        }

        

    public function somarDiasDataAtual($dias)

    {

         return strftime("%d/%m/%Y", strtotime("+{$dias} days")); 

    }

        

    public function somarMesDataAtual($meses)

    {

         return strftime("%d/%m/%Y", strtotime("+{$meses} months"));

    }

        

    public function forcarDownload($arquivo,$descricao)

    {

            header("Content-type: application/save");

            header("Content-Length:".filesize($arquivo));

            header('Content-Disposition: attachment; filename="'.$descricao.'"');

            readfile("$arquivo");

    }

        

    public function validaAcessoPagina($acessos,$pagina)

    {

           if(in_array($pagina,$acessos['FUNC']))

           {

                return true;

           }

           else

           {

                return false;

           }

    }
	
	
/*
Nome: Converte data
Autor: Marcos Rosa
Criado em: 13/05/11
Modificado por: 
Descrição: Converte uma data e hora no formato 2011-05-13 15:19:51 para 13/05/2011 15:19:51
*/

function converteData($data){
	
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

/*
Nome: Converte data 2
Autor: Marcos Rosa
Criado em: 13/05/11
Modificado por: 
Descrição: Converte uma data e hora no formato 13/05/2011 15:19:51 para 2011-05-13 15:19:51 
*/

function converteData2($data){
	
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

/*
Nome: Função valida e-mail 
Autor: Marcos Rosa
Criado em: 07/05/11
Modificado por: Marcos Rosa em 08/05/11
Descrição: Retorna FALSE se o e-mail não for válido e TRUE se for válido
*/
function validaEmail($email){
	
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

/*
Nome: Função valida data 
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

}

?>