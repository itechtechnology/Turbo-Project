<?php

require '../../conf/lock.php';

$conn = ADONewConnection('postgres7');
$conn->PConnect('localhost', 'postgres', 'paavo123', 'turbo-project') or die('merda');
if (isset($conn)) {
    echo 'conectado';
} else {
    echo 'nao conectado';
}

phpinfo();
?>
