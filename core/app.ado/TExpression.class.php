<?php

/* Classe abstrata para
 * gerenciar express�es
 */

abstract class TExpression {
    //operadores logicos

    const AND_OPERATOR = 'AND ';
    const OR_OPERATOR = 'OR ';
    const VAZIO = '';

    abstract public function dump();
}

?>
