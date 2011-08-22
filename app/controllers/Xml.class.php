<?php

//require '../../conf/lock.php';

/**
 * Description of Xml
 *
 * @author liviacorreia
 */
class Xml {

    private $tarefa;

    function __construct() {
        $this->tarefa = new TarefasRecord();
    }

    public function gerarXml($projeto) {
        $tarefas = $this->tarefa->getTarefasProjeto($projeto['CD_PROJETO']['1']);

        $arquivo = fopen("../../core/gantt/gantt.xml", "w+");
//        if ($arquivo->exists()) {
//            unlink($arquivo);
//            $arquivo = fopen("../../core/gantt/gantt.xml", "x+");
//        }
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

    public static function converteData($data) {
        list ($ano, $mes, $dia) = split('[/.-]', $data);
        if ($mes < 10) {
            $mes = substr($mes, 1);
        }
        $arr = array($ano, $mes, $dia);
        return $arr;
    }

    public function carregarSubTarefas($conteudo, $tarefas) {
        $total = count($tarefas['CD_TAREFA']);
        for ($i = 1; $i <= $total; $i++) {
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
            } else {
                $conteudo = $this->carregarSubTarefas($conteudo, $sub);
                $conteudo.="</childtasks>";
                $conteudo.="</task>";
            }
        }
        return $conteudo;
    }

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
