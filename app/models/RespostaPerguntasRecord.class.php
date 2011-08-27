<?php

/**
 * Classe que faz a ligaçào entre a tabela usuário e as perguntas secretas 
 * 
 * @package app
 * @subpackage models
 * @author Marcos Rosa
 * @since 29/07/2011
 */
class RespostaPerguntasRecord extends ManipulaBanco {

    function __construct() {
        
    }

    /**
     * Recebe fk_cd_usuario, fk_cd_perguntas e a resposta da pergunta
     * 
     * @param array $dados
     */
    public function cadastrarResposta($dados) {

        if ($this->salvar($dados)) {

            return $this->ultimoId('opcoesperguntas_cd_pergunta_seq', 'postgres'); //Último id da sequencia
        } else {
            echo "Erro ao cadastrar nova resposta a pergunta secreta!";
            exit;
        }
    }

}

?>
             