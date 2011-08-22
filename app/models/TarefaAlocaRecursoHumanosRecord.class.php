<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TarefaAlocaRecursoHumanos
 *
 * @author liviacorreia
 */
class TarefaAlocaRecursoHumanosRecord extends ManipulaBanco {

    public function cadastrarRecursoHumano($dados) {
        return $this->salvar($dados);
    }

}

?>
