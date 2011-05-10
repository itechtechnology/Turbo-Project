<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TCriteria
 *
 * @author LÍVIA CORREIA
 */
class TCriteria extends TExpression {

    private $expressoes;
    private $operadores;
    private $propriedades;

    public function add(TExpression $expressao, $operador = self::AND_OPERATOR) {
        if (empty($this->expressoes)) {
//            echo 'nada';
        //    unset($operador);
        } else {
            $this->operadores[] = $operador;
        }
        $this->operadores[] = $operador;
        $this->expressoes[] = $expressao;
    }

    public function dump() {
        $resultado = '';
        if (is_array($this->expressoes)) {
            foreach ($this->expressoes as $i => $expressao) {
                $operador = $this->operadores[$i];
                $resultado .= $operador . $expressao->dump() . ' ';
            }
            $resultado = trim($resultado);
            return "({$resultado})";
        }
    }

    public function setProperty($propriedade, $valor) {
        $this->propriedades[$propriedade] = $valor;
    }

    public function getProperty($propriedade) {
        return $this->propriedades[$propriedade];
    }

}

?>
