<?php

/**
 * Manipulador de status de projetos
 *
 * @package app
 * @subpackage models
 * @author Anderson Rodrigues
 * @since 11/05/2011
 */

class StatusProjeto extends ManipulaBanco {

    /**
     * Seleciona status
     *
     * @return coleca 
     */
    public function listarStatus() {

        $sql = "SELECT cd_status, nome_status FROM status ORDER BY nome_status";
        return $this->executarPesquisa($sql);
    }

    /**
     * Seleciona o id do status pelo nome
     * 
     * @param string $nome_status
     * @return int
     */
    public function getCodByName($nome_status) {
        $lib = new Lib();
        $nome_status = $lib->antiInjection($nome_status);
        $sql = "SELECT cd_status FROM status WHERE nome_status='" . $nome_status
                . "' OR UPPER(nome_status)=UPPER('" . $nome_status . "')";
        $result = $this->executarPesquisa($sql);
        return $result['CD_STATUS'][1];
    }

}

?>
