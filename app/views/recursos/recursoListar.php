<?php

require '../../conf/lock.php';

$tpl = new sistTemplate(APPTPLDIR . '/recursoListar.tpl.html');

$recurso = new RecursosRecord();
$recursos = $recurso->listarRecurso();
$total = count($recursos['ID']);
for ($i = 1; $i <= $total; $i++) {
    $tpl->NOME = $recursos['NOME'][$i];
    $tpl->DATA_CADASTRO = $recursos['DT_CADASTRO'][$i];
    $tpl->CUSTO = "R$ " . $recursos['CUSTO'][$i];
    $tpl->DESCRICAO = $recursos['DESCRICAO'][$i];
    $tpl->PROJETO_ALOCADO = $recursos['PJ_ALOCADO'][$i];
    $tpl->block("BLOCK_LISTA");
}
$tpl->show();
?>
