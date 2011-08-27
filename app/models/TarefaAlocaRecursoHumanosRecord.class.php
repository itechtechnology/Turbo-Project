<?php

/**
 * Classe que representa um objeto tarefa aloca recurso humano
 * Utilizada para manipular objetos do banco de dados
 * 
 * @package app
 * @subpackage models
 * @author Paavo Soeiro
 * 
 */
class TarefaAlocaRecursoHumanosRecord extends ManipulaBanco {

    /**
     * Metodo responsavel por alocar um recurso humano a uma tarefa
     * 
     * @param array $dados dados a serem inseridos
     * @return boolean 
     */
    public function cadastrarRecursoHumano($dados) {
        return $this->salvar($dados);
    }

}

?>
