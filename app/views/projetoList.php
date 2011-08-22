<?php

$time = microtime();

require '../../conf/lock.php';
if (!isset($_SESSION['login'])) {
    echo "<script type='text/javascript'>alert('Voce precisa estar logado');
        location.href='../../web'</script>";
} else {
    $projeto = new ProjetosRecord();
    /*
     * @TODO preciso que marcos implemente o metodo listarColaboradoresAtivos
     * para que eu possa listar os usuarios a serem selecionados
     */

    $lib = new Lib();

    $tpl = new sistTemplate(APPTPLDIR . '/projetosList.tpl.html');
    $tpl->addFile('TOPO', APPTPLDIR . '/topo.tpl.html');
    $tpl->addFile('MENULATERAL', APPTPLDIR . '/menuLateral.tpl.html');
    $tpl->addFile('RODAPE', APPTPLDIR . '/rodape.tpl.html');
    $u = new UsuariosRecord();
    $uNome = $u->getNome($_SESSION['login']);
    $tpl->USUARIO_LOGADO = $uNome;
    $tpl->IMAGEDIR = APPIMAGEDIR;
    $tpl->CSSDIR = APPCSSDIR;
    $tpl->JSDIR = APPJSDIR;
    $tpl->WEBROOT = APPWEBROOT;
    $tpl->SITETITLE = SITETITLE;
    $tpl->FAVICON = FAVICON;
    $tpl->ANIMATEDFAVICON = ANIMATEDFAVICON;
    $tpl->MEMORYUSAGE = number_format(intval(memory_get_usage() / 1000), 0, ',', '.');
    $tpl->MEMORYPICK = number_format(intval(memory_get_peak_usage() / 1000), 0, ',', '.');
    $tpl->CONTROLLER = $_SERVER["PHP_SELF"];
    $tpl->TITULOLISTAGEM = 'Projetos';
    $tpl->TITULOPROCURAR = 'LOCALIZAR';



    if (isset($_GET['orderBy']) and isset($_GET['sort'])) {
        $ordCampo = $_GET['orderBy'];

        switch ($_GET['orderBy']) {
            case 'cd_projeto': {
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
            case 'nome_projeto': {
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
            case 'gerente': {
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
            case 'status': {
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
        $ordCampo = 'nome_projeto';

        $tpl->IMGORDEM1 = '';
        $tpl->IMGORDEM2 = '<img src="' . APPIMAGEDIR . '/down.gif" />';
        $tpl->IMGORDEM3 = '';
        $tpl->IMGORDEM4 = '';
        $tpl->SORT = 'DESC';
    }

    if (empty($_GET['pesquisa'])) {
        $projetos = $projeto->getProjetos('', $ordCampo, $tpl->SORT);
    } else {
        $projetos = $projeto->getProjetos($_GET['pesquisa'], $ordCampo, $tpl->SORT);
    }

    $totalprojetos = count($projetos['CD_PROJETO']);

    $tpl->TOTAL = $totalprojetos;

    if (($totalprojetos > 0) and ($totalprojetos > 1)) {
        $tpl->LEGENDA = ' projetos encontrados.';
    } else {
        $tpl->LEGENDA = ' projeto encontrado.';
    }

    for ($i = 1; $i <= $totalprojetos; $i++) {
        if ($i % 2 != 0) {
            $tpl->CLASS = '';
        } else {
            $tpl->CLASS = 'class="odd"';
        }

        $tpl->CD_PROJETO = $projetos['CD_PROJETO'][$i];
        $tpl->NOME_PROJETO = utf8_decode($projetos['NOME_PROJETO'][$i]);
        $tpl->GERENTE = $projetos['GERENTE'][$i];
        $tpl->STATUS = $projetos['STATUS'][$i];
        $tpl->EDITAR = 'projetoEdit.php?cd_projeto=' . $projetos['CD_PROJETO'][$i];
        $tpl->EDITARCRONO = 'projetoEditCrono.php?cd_projeto=' . $projetos['CD_PROJETO'][$i];
        $tpl->block('BLOCK_LISTAGEM');
    }

    $tpl->TIME = number_format((microtime() - $time), 3, ',', '.');
    $tpl->show();
}
?>