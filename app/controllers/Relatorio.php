<?php
/**
 * Classe fachada para gerar relatorios
 * 
 * @package app
 * @subpackage controllers
 * @author Paavo Soeiro
 */
include 'RelatorioFactory.class.php';

$controller = new RelatorioFactory();
$controller->gerarRelatorio($_GET['relatorio']);
?>
