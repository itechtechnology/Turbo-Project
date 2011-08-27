<?php

/**
 * Classe genérica para manipulação de registros dos endereços
 * 
 * @package app
 * @subpackage models
 * @author Marcos Rosa
 * @since 20/07/2011
 * 
 */
class EnderecosRecord extends ManipulaBanco {

    /**
     * Construtor da classe
     */
    function __construct() {
        
    }

    /**
     * Metodo que inseri um endereco
     * 
     * @param array $endereco
     * @return boolean
     */
    public function cadastrarEndereco($endereco) {

        if ($this->salvar($endereco)) {

            return $this->ultimoId('endereco_cd_endereco_seq', 'postgres'); //Último id da sequencia
        } else {
            echo "Erro ao cadastrar endereço!";
            exit;
        }
    }

    /**
     * Metodo que atualiza um endereco
     *
     * @param array $dados
     * @param int $cd_endereco id da tareda
     * @return boolean 
     */
    public function atualizarEndereco($dados, $cd_endereco) {

        return $this->atualizar($dados, $cd_endereco);
    }

    /**
     * Metodo que seleciona um endereco pelo id
     * 
     * @param int $cd_endereco id do endereco
     * @return array dados do endereco 
     */
    public function retornaDados($cd_endereco) {

        $sql = "SELECT * FROM endereco WHERE cd_endereco = '$cd_endereco'";
        $result = $this->executarPesquisa($sql);
        return $result;
    }

}

?>