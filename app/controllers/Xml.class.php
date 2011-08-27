<?php

/**
 * Classe que gera um xml utilizado para criar o grafico de Gantt
 *
 * @package app
 * @subpackage controllers
 * @author Paavo Soeiro
 */


/**
 * Classe que gera um xml utilizado para criar o grafico de Gantt
 *
 * @package app
 * @subpackage controllers
 * @author Paavo Soeiro
 */
class Xml {

    /**
     * Variavel de tarefas
     * 
     * @var tarefa 
     * @access private
     */
    private $tarefa;

    /**
     * Metodo contrutor da classe
     * inicializa a varivel tarefa
     */
    function __construct() {
        $this->tarefa = new TarefasRecord();
    }
    
    /**
     * Metodo que gera o xml
     * Recebi o codigo do projeto e devolvi uma string com o caminho do xml
     * 
     * @param projeto $projeto
     * @return string 
     */
    public function gerarXml($projeto) {
        $tarefas = $this->tarefa->getTarefasProjeto($projeto['CD_PROJETO']['1']);

        $arquivo = fopen("../../core/gantt/gantt.xml", "w+");
        $data = strrev($projeto['DT_INICIO_PROJ']['1']);
        $data = substr($data, -10);
        $data = strrev($data);
        $arr = Xml::converteData($data);

        //montando xml
        $conteudo = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
        $conteudo.="<projects>";
        $conteudo.="<project id = \"";
        $conteudo.= $projeto['CD_PROJETO']['1'] . "\"";
        $conteudo.=" name = \"";
        $conteudo.=$projeto['NOME_PROJETO']['1'] . "\"";
        $conteudo.=" startdate = \"";
        $conteudo.=$arr[0] . "," . $arr[1] . "," . $arr[2] . "\"";
        $conteudo.=">";


        /*  <task id="1">
          <name>project1 task1</name>
          <est>2010,12,14</est>
          <duration>120</duration>
          <percentcompleted>60</percentcompleted>
          <predecessortasks></predecessortasks>
          </task>
         */
        $conteudo = $this->carregarSubTarefas($conteudo, $tarefas);


        $conteudo.="</project>";
        $conteudo.="</projects>";

        fwrite($arquivo, $conteudo);
        fclose($arquivo);
        return "../../core/gantt/gantt.xml";
    }

    /**
     * Metodo que converte uma data para um array com o formato adequado ao xml
     * 
     * @static
     * @param string $data
     * @return array
     */
    public static function converteData($data) {
        list ($ano, $mes, $dia) = split('[/.-]', $data);
        if ($mes < 10) {
            $mes = substr($mes, 1);
        }
        $arr = array($ano, $mes, $dia);
        return $arr;
    }

    /**
     * Metodo que carrega as tarefa e subtarefas
     * Um metodo recursivo que devolvi uma string
     * 
     *
     * @param string $conteudo
     * @param tarefa $tarefas
     * @return string 
     */
    public function carregarSubTarefas($conteudo, $tarefas) {
        $total = count($tarefas['CD_TAREFA']);

        for ($i = 1; $i <= $total; $i++) {
            if ($z == 1) {
                
            } else {
                $conteudo.="<task id=\"";
                $conteudo.=$tarefas['CD_TAREFA'][$i];
                $conteudo.="\">";
                $data = strrev($tarefas['DT_INCIO'][$i]);
                $data = substr($data, -10);
                $data = strrev($data);
                $arr = Xml::converteData($data);
                $conteudo.= "<name>";
                $conteudo.= $tarefas['NOME_TAREFA'][$i];
                $conteudo.= "</name>";
                $conteudo.= "<est>";
                $conteudo.=$arr[0] . "," . $arr[1] . "," . $arr[2];
                $conteudo.= "</est>";
                $conteudo.="<duration>";
                $duracao = (Xml::diferencaDatas($tarefas['DT_INCIO'][$i], $tarefas['DT_PREVISAO'][$i])) * 24;
                $conteudo.= $duracao;
                $conteudo.="</duration>
            <percentcompleted>";
                $conteudo.=$tarefas['PCOMPLETO'][$i];
                $conteudo.="</percentcompleted>
            <predecessortasks></predecessortasks>
            <childtasks>";
                //aqui verifico se possui subtarefas, caso sim chamo o meto
                //recursivamente
                $sub = $this->tarefa->getSubTarefas($tarefas['CD_TAREFA'][$i]);
                $totalsub = count($sub['CD_TAREFA']);
                if ($totalsub == 0) {
                    $conteudo.="</childtasks>";
                    $conteudo.="</task>";
                    $z = 0;
                } else {

                    $conteudo = $this->carregarSubTarefas($conteudo, $sub);
                    $conteudo.="</childtasks>";
                    $conteudo.="</task>";
                    $z = 1;
                }
            }
        }
        return $conteudo;
    }

    
    /**
     * Metodo que calcula o numero de dias entre datas
     *
     * @static
     * @param date $dataIni
     * @param date $dataFim
     * @return int 
     */
    public static function diferencaDatas($dataIni, $dataFim) {
        $dataIni = strrev($dataIni);
        $dataIni = substr($dataIni, -10);
        $dataIni = strrev($dataIni);

        $dataFim = strrev($dataFim);
        $dataFim = substr($dataFim, -10);
        $dataFim = strrev($dataFim);

        $auxInicial = strtotime($dataIni);
        $auxFinal = strtotime($dataFim);
        $intervalo = ($auxFinal - $auxInicial) / 86400;
        $intervalo = round($intervalo);
        if ($intervalo == '0') {
            return '1';
        } else {
            return $intervalo;
        }
    }

}

?>
