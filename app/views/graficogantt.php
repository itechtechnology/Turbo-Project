<?php

require '../../conf/lock.php';
include_once '../controllers/Xml.class.php';
$tpl = new sistTemplate(APPTPLDIR . '/gantt.tpl.html');
$tpl->addFile('TOPO', APPTPLDIR . '/topo.tpl.html');
$tpl->addFile('MENULATERAL', APPTPLDIR . '/menuLateral.tpl.html');
$tpl->addFile('RODAPE', APPTPLDIR . '/rodape.tpl.html');
//    include 'grid.php';
$tpl->IMAGEDIR = APPIMAGEDIR;
$tpl->CSSDIR = APPCSSDIR;
$tpl->JSDIR = APPJSDIR;
//$tpl->WEBROOT = APPWEBROOT;
$tpl->SITETITLE = SITETITLE;
$tpl->FAVICON = FAVICON;
$tpl->ANIMATEDFAVICON = ANIMATEDFAVICON;
$var = 'GanttDiv';
$proj = new ProjetosRecord();
//        $projeto = $proj->dadosProjeto($cd_projeto);
$id = $_POST['cd_projeto'];

$projeto = $proj->dadosProjeto($id);
$nomeProj = $projeto['NOME_PROJETO']['1'];
$tpl->NOME_PROJETO = $nomeProj;
$tarefa = new TarefasRecord();


$tarefas = $tarefa->getTarefasProjeto($projeto['CD_PROJETO']['1']);
//        $str = implode("|", $projeto);
//        $xml = "../../core/gantt/gantt.xml";
$xmlfile = new Xml;
$xml = $xmlfile->gerarXml($projeto);
//$data = strrev($projeto['DT_INICIO_PROJ']['1']);
//echo $data."<br/>";
//$data1 = substr($data, -10);
//echo $data1."<br/>";
//$data2 = strrev($data1);
//echo $data2;
//date('l jS \of F Y h:i:s A');
//echo date("j, n, Y", $projeto['DT_INICIO_PROJ']['0']);

echo "<script type=\"text/javascript\" language=\"JavaScript\">
            $(document).ready(function(){
                createChartControl('" . $var . "','" . $xml . "');
            });
        </script>";
$tpl->GANTT = "<script type=\"text/javascript\" language=\"JavaScript\">
            $(document).ready(function(){
                createChartControl('" . $var . "','" . $xml . "');
            });
        </script>";
$tpl->show();
?>
