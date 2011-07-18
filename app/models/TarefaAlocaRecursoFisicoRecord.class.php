<?php

/**
 * Description of TarefaAlocaRecursoFisicoRecord
 *
 * @author Paavo Soeiro
 */
class TarefaAlocaRecursoFisicoRecord extends ManipulaBanco {

    public function alocarRecurso($dados) {
        return $this->salvar($dados);
    }

}

?>
