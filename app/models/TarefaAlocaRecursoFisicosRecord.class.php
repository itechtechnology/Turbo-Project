<?php

/**
 * Description of TarefaAlocaRecursoFisicoRecord
 *
 * @author Paavo Soeiro
 */
class TarefaAlocaRecursoFisicosRecord extends ManipulaBanco {

    public function alocarRecurso($dados) {
        return $this->salvar($dados);
    }

}

?>
