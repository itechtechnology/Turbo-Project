<?php

/**
 * Classe que representa um objeto tarefa aloca recurso fisico
 * Utilizada para manipular objetos do banco de dados
 * 
 * @package app
 * @subpackage models
 * @author Paavo Soeiro
 * 
 */
class TarefaAlocaRecursoFisicosRecord extends ManipulaBanco {
    /**
     * Metodo responsavel por alocar um recurso fisico a uma tarefa
     * 
     * @param array $dados dados a serem inseridos
     * @return boolean 
     */
    public function alocarRecurso($dados) {
        return $this->salvar($dados);
    }

}

?>
