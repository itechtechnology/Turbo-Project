<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TFilter
 *
 * @author LÍVIA CORREIA
 */
class TFilter extends TExpression {

    private $variavel;
    private $operador;
    private $valor;

    function __construct($variavel, $operador, $valor) {
        $this->variavel = $variavel;
        $this->operador = $operador;
        $this->valor = $this->transform($valor);
    }

    public function transform($valor) {
        if (is_array($valor)) {
            foreach ($valor as $v) {
                if (is_integer($v)) {
                    $temp[] = $v;
                } else if (is_string($v)) {
                    $temp[] = "'$v'";
                }
                $resultado = '(' . implode(',', $temp) . ')';
            }
        } else if (is_string($valor)) {
            $resultado = "'$valor'";
        } else if (is_null($valor)) {
            $resultado = 'NULL';
        } else if (is_bool($valor)) {
            $resultado = $valor ? 'TRUE' : 'FALSE';
        } else {
            $resultado = $valor;
        }
        return $resultado;
    }

    public function dump() {
        return "{$this->variavel} {$this->operador} {$this->valor}";
    }

}

?>
