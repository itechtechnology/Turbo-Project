<?php

require '../../conf/lock.php';

$tpl = new sistTemplate(APPTPLDIR . '/recurso.tpl.html');

$tpl->CONTROLLER = '../controllers/RecursoFisico.php?acao=salvar';
$tpl->NOME = '';
$tpl->CUSTO = '0';
$tpl->DESCRICAO = '';
$tpl->show();
?>
