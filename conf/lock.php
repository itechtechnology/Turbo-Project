<?php

/* ARQUIVO DE CONFIGURAÇÕES 
  Autor: Anderson Rodrigues
  Data de modificação: 07-07-2011

 */
//editado por Anderson Rodrigues evitar erros de warnings 
error_reporting(0);

@ session_start();

/* seto a codificação como utf-8 */
header('Content-Type: text/html; charset=utf-8');

if (file_exists('config.inc.php')) {
    include_once 'config.inc.php';
} elseif (file_exists('conf/config.inc.php')) {
    include_once 'conf/config.inc.php';
} elseif (file_exists('../conf/config.inc.php')) {
    include_once '../conf/config.inc.php';
} elseif (file_exists('../../conf/config.inc.php')) {
    include_once '../../conf/config.inc.php';
}

if (file_exists('core/adodb5/adodb.inc.php')) {
    include_once 'core/adodb5/adodb.inc.php';
} elseif (file_exists('../../core/adodb5/adodb.inc.php')) {
    include_once '../../core/adodb5/adodb.inc.php';
}

function __autoload($classe) {
    if (file_exists('../../../core/app.ado/' . $classe . '.class.php')) {
        include_once '../../../core/app.ado/' . $classe . '.class.php';
    } elseif (file_exists('../../core/app.ado/' . $classe . '.class.php')) {
        include_once '../../core/app.ado/' . $classe . '.class.php';
    } elseif (file_exists('../core/app.ado/' . $classe . '.class.php')) {
        include_once '../core/app.ado/' . $classe . '.class.php';
    } elseif (file_exists('../app.ado/' . $classe . '.class.php')) {
        include_once '../app.ado/' . $classe . '.class.php';
    } elseif (file_exists('../../app.ado/' . $classe . '.class.php')) {
        include_once '../../app.ado/' . $classe . '.class.php';
    } elseif (file_exists('core/app.ado/' . $classe . '.class.php')) {
        include_once 'core/app.ado/' . $classe . '.class.php';
    } elseif (file_exists('../models/' . $classe . '.class.php')) {
        include_once '../models/' . $classe . '.class.php';
    } elseif (file_exists('app/models/' . $classe . '.class.php')) {
        include_once 'app/models/' . $classe . '.class.php';
    } elseif (file_exists('../app/models/' . $classe . '.class.php')) {
        include_once '../app/models/' . $classe . '.class.php';
    }
}

?>