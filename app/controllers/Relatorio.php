<?php

include 'RelatorioFactory.class.php';

$controller = new RelatorioFactory();
$controller->gerarRelatorio($_GET['relatorio']);
?>
