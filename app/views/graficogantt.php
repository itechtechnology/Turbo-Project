<?php
/**
 * Esta pagina renderiza uma tela para visualizar o grafico de 
 * Gantt de um projeto.
 * 
 * @package app
 * @subpackage views
 * @author Paavo Soeiro
 * 
 * 
 */

session_start();
require '../../conf/lock.php';
include_once '../controllers/Xml.class.php';

if (!isset($_SESSION['login'])) {
    echo "<script type='text/javascript'>alert('Voce precisa estar logado');
        location.href='../../web'</script>";
} else {
    $tpl = new sistTemplate(APPTPLDIR . '/gantt.tpl.html');
    $tpl->addFile('TOPO', APPTPLDIR . '/topo.tpl.html');
    $tpl->addFile('MENULATERAL', APPTPLDIR . '/menuLateral.tpl.html');
    $tpl->addFile('RODAPE', APPTPLDIR . '/rodape.tpl.html');
    $tpl->IMAGEDIR = APPIMAGEDIR;
    $tpl->CSSDIR = APPCSSDIR;
    $tpl->JSDIR = APPJSDIR;
    $tpl->SITETITLE = SITETITLE;
    $tpl->FAVICON = FAVICON;
    $tpl->ANIMATEDFAVICON = ANIMATEDFAVICON;
    $var = 'GanttDiv';
    $u = new UsuariosRecord();
    $uNome = $u->getNome($_SESSION['login']);
    $tpl->USUARIO_LOGADO = $uNome;
    $lib = new Lib();
    $proj = new ProjetosRecord();
    $id = $_POST['cd_projeto'];

    $projeto = $proj->dadosProjeto($id);
    $nomeProj = $projeto['NOME_PROJETO']['1'];
    $tpl->NOME_PROJETO = $nomeProj;
    $tarefa = new TarefasRecord();

    $tarefas = $tarefa->getTarefasProjeto($projeto['CD_PROJETO']['1']);
    $xmlfile = new Xml;
    $xml = $xmlfile->gerarXml($projeto);
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
}
?>
