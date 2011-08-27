<?php

/**
 * Classe genérica para manipulação de registros das mensagens
 * 
 * @package app
 * @subpackage models
 * @author Marcos Rosa
 * @since 12/08/2011
 */
class MensagemsRecord extends ManipulaBanco {

    /**
     * Construtor da classe
     */
    function __construct() {
        
    }

    /**
     * Cadastra uma mensagem
     * 
     * @param array $dados
     * @return boolean 
     */
    public function cadastrarMensagem($dados) {

        if ($this->salvar($dados)) {

            return TRUE;
        } else {
            echo "Erro ao cadastrar mensagem!";
            exit;
        }
    }

    /**
     * Exclui uma mensagem
     *
     * @param int $cd
     * @return boolean
     */
    public function excluirMensagem($cd) {

        $criteria = new TCriteria();

        $criteria->add(new TFilter('cd_mensagem', '=', $cd));

        return $this->deletar($criteria);
    }

    /**
     * Atualiza uma mensagem
     *
     * @param array $dados
     * @param int $cd_mensagem
     * @return boolean 
     */
    public function atualizarMensagem($dados, $cd_mensagem) {

        return $this->atualizar($dados, $cd_mensagem);
    }

    /**
     * Lista mensagens por destinatario
     * 
     * @param int $destinatario
     * @return colecao 
     */
    public function listaMensagens($destinatario) {

        $sql = "SELECT * FROM mensagem WHERE destinatario = '$destinatario' ORDER BY hora DESC;";
        $result = $this->executarPesquisa($sql);

        return $result;
    }

    /**
     * Retorna uma mensagem pelo id
     *
     * @param int $cd_mensagem
     * @return array 
     */
    public function getMensagem($cd_mensagem) {

        $sql = "SELECT * FROM mensagem WHERE cd_mensagem = '$cd_mensagem';";
        $result = $this->executarPesquisa($sql);

        return $result;
    }

}

?>