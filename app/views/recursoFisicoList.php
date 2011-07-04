<?php

require '../../conf/lock.php';
$recurso = new RecursoFisicosRecord;
$lib = new Lib();
$tpl = new sistTemplate(APPTPLDIR . '/recursosFisicoList.tpl.html');
$tpl->addFile('TOPO', APPTPLDIR . '/topo.tpl.html');
$tpl->addFile('MENULATERAL', APPTPLDIR . '/menuLateral.tpl.html');
//$tpl->addFile('RODAPE', APPTPLDIR . '/rodape.tpl.html');
$tpl->IMAGEDIR = APPIMAGEDIR;
$tpl->CSSDIR = APPCSSDIR;
$tpl->JSDIR = APPJSDIR;
//$tpl->WEBROOT = APPWEBROOT;
$tpl->SITETITLE = SITETITLE;
$tpl->FAVICON = FAVICON;
$tpl->ANIMATEDFAVICON = ANIMATEDFAVICON;
//$tpl->MEMORYUSAGE = number_format(intval(memory_get_usage() / 1000), 0, ',', '.');
//$tpl->MEMORYPICK = number_format(intval(memory_get_peak_usage() / 1000), 0, ',', '.');
$tpl->CONTROLLER = $_SERVER["PHP_SELF"];
$tpl->TITULOLISTAGEM = 'Recursos';
$tpl->TITULOPROCURAR = 'LOCALIZAR';
$tpl->DICA = 'DICA';
$tpl->USUARIO = $_SESSION['login'];

if (isset($_GET['orderBy']) and isset($_GET['sort'])) {
    $ordCampo = $_GET['orderBy'];
    switch ($ordCampo) {
        case 'cd_recurso': {
                if ($_GET['sort'] == 'ASC') {
                    $tpl->IMGORDEM1 = '<img src="' . APPIMAGEDIR . '/down.gif" />';
                    $tpl->IMGORDEM2 = '';
                    $tpl->IMGORDEM3 = '';
                    $tpl->IMGORDEM4 = '';
                    $tpl->SORT = 'DESC';
                } else {
                    $tpl->IMGORDEM1 = '<img src="' . APPIMAGEDIR . '/up.gif" />';
                    $tpl->IMGORDEM2 = '';
                    $tpl->IMGORDEM3 = '';
                    $tpl->IMGORDEM4 = '';
                    $tpl->SORT = 'ASC';
                }
                break;
            }
        case 'nome_recurso': {
                if ($_GET['sort'] == 'ASC') {
                    $tpl->IMGORDEM1 = '';
                    $tpl->IMGORDEM2 = '<img src="' . APPIMAGEDIR . '/down.gif" />';
                    $tpl->IMGORDEM3 = '';
                    $tpl->IMGORDEM4 = '';
                    $tpl->SORT = 'DESC';
                } else {
                    $tpl->IMGORDEM1 = '';
                    $tpl->IMGORDEM2 = '<img src="' . APPIMAGEDIR . '/up.gif" />';
                    $tpl->IMGORDEM3 = '';
                    $tpl->IMGORDEM4 = '';
                    $tpl->SORT = 'ASC';
                }
                break;
            }
        case 'ds_recurso': {
                if ($_GET['sort'] == 'ASC') {
                    $tpl->IMGORDEM1 = '';
                    $tpl->IMGORDEM2 = '';
                    $tpl->IMGORDEM3 = '<img src="' . APPIMAGEDIR . '/down.gif" />';
                    $tpl->IMGORDEM4 = '';
                    $tpl->SORT = 'DESC';
                } else {
                    $tpl->IMGORDEM1 = '';
                    $tpl->IMGORDEM2 = '';
                    $tpl->IMGORDEM3 = '<img src="' . APPIMAGEDIR . '/up.gif" />';
                    $tpl->IMGORDEM4 = '';
                    $tpl->SORT = 'ASC';
                }
                break;
            }
        case 'custo': {
                if ($_GET['sort'] == 'ASC') {
                    $tpl->IMGORDEM1 = '';
                    $tpl->IMGORDEM2 = '';
                    $tpl->IMGORDEM3 = '';
                    $tpl->IMGORDEM4 = '<img src="' . APPIMAGEDIR . '/down.gif" />';
                    $tpl->SORT = 'DESC';
                } else {
                    $tpl->IMGORDEM1 = '';
                    $tpl->IMGORDEM2 = '';
                    $tpl->IMGORDEM3 = '';
                    $tpl->IMGORDEM4 = '<img src="' . APPIMAGEDIR . '/up.gif" />';
                    $tpl->SORT = 'ASC';
                }
                break;
            }
    }
} else {
    $ordCampo = 'nome_recurso';

    $tpl->IMGORDEM1 = '';
    $tpl->IMGORDEM2 = '<img src="' . APPIMAGEDIR . '/down.gif" />';
    $tpl->IMGORDEM3 = '';
    $tpl->IMGORDEM4 = '';
    $tpl->SORT = 'DESC';
}
//
if (empty($_GET['pesquisa'])) {
    $recursos = $recurso->listarRecurso($ordCampo, $tpl->SORT);
} else {
    $texto = $lib->formatarString($_GET['pesquisa']);
    $recursos = $recurso->getRecurso($texto, $ordCampo, $tpl->SORT);
}
//
$totalrecursos = count($recursos['CD_RECURSO']);
if ($totalrecursos == 0)
    $tpl->TOTAL = 0;
$tpl->TOTAL = $totalrecursos;
//

if (($totalrecursos > 0) and ($totalrecursos > 1)) {
    $tpl->LEGENDA = ' recursos encontrados.';
} else {
    $tpl->LEGENDA = ' recurso encontrado.';
}
//
for ($i = 1; $i <= $totalrecursos; $i++) {
    if ($i % 2 != 0) {
        $tpl->CLASS = '';
    } else {
        $tpl->CLASS = 'class="odd"';
    }
//
    $tpl->CD_RECURSO = $recursos['CD_RECURSO'][$i];
    $tpl->NOME_RECURSO = utf8_decode($recursos['NOME_RECURSO'][$i]);
    $tpl->DS_RECURSO = $recursos['DS_RECURSO'][$i];
    $tpl->CUSTO = $recursos['CUSTO'][$i];
    // $tpl->EDITAR = 'projetoEdit.php?cd_recurso=' . $recursos['CD_RECURSO'][$i];
    $tpl->block('BLOCK_LISTAGEM');
}
//
//$tpl->TIME = number_format((microtime() - $time), 3, ',', '.');
//$recurso = new RecursosRecord();
//$recursos = $recurso->listarRecurso();
//if(isset($recurso->listarRecurso())){
//    $recursos = $recurso->listarRecurso();
//}
//$total = count($recursos['ID']);
//for ($i = 1; $i <= $total; $i++) {
//    $tpl->NOME = $recursos['NOME'][$i];
//    $tpl->DATA_CADASTRO = $recursos['DT_CADASTRO'][$i];
//    $tpl->CUSTO = "R$ " . $recursos['CUSTO'][$i];
//    $tpl->DESCRICAO = $recursos['DESCRICAO'][$i];
//    $tpl->PROJETO_ALOCADO = $recursos['PJ_ALOCADO'][$i];
//    $tpl->block("BLOCK_LISTA");
//}
$tpl->show();
?>
