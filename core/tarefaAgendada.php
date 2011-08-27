<?php
/**
 * Classe responsavel por atualizar as tarefas
 * É executada todo dia a meia noite 0:00:00
 * 
 * @package core
 * @author Paavo Soeiro
 * 
 */

require '../conf/lock.php';

TarefasRecord::atualizarTarefas();
?>
