<?php
 
//CLASSE PARA MANIPULAR E VALIDAR STRINGS, DATAS, ETC...

class Lib
{
    public function verificar($variavel)
    {
        $variavel = mysql_escape_string($variavel); // strings
                $variavel = str_replace("<html>","",$variavel); // previne html
                $variavel = str_replace("<script","",$variavel); // previne javascript
                $variavel = str_replace("href=","",$variavel); // previne links

        return $variavel;
    }
        
        function antiInjection($string)
        {
                $string = preg_replace(sql_regcase("/(from|select|insert|delete|update|where|drop table|drop database|show tables|create|alter table|#|\*|--|\\\\)/"),"",$string);
                $string = strip_tags($string);//tira tags html e php
                $string = addslashes($string);//Adiciona barras invertidas a uma string
                
                return $string;
        }
        
        public function formatarString($palavra)
    {
       $palavra_formatada = trim($palavra);
       $palavra_formatada = strtolower($palavra_formatada);
           $palavra_formatada = $this->antiInjection($palavra_formatada);

       return $palavra_formatada;
    }

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

    public function converterDataToUs($data)
    {
       $dia = substr($data,0,2);
       $mes = substr($data,3,2);
       $ano = substr($data,6,4);

       return "{$ano}-{$mes}-{$dia}";
    }

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
        // f = física CPF
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

                return $mes_port = "Março";
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
        
        public function numeroMeses($dias){
                 
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
                        RETORNA O NÚMERO DE DIAS ENTRE AS DATAS INFORMADAS
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
                } else
                {
                        return false;
                }
        }
}
?>
