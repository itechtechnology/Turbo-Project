<?php

/**
 * Description of StatusProjeto
 *
 * @author Anderson Rodrigues
 * Data: 11/05/2011
 * Classe: Manipulador de status de projetos
 */
include_once '../../core/app.ado/ManipulaBanco.class.php';

class StatusProjeto extends ManipulaBanco {

    //put your code here
    public function listarStatus() {

        $sql = "SELECT cd_status, nome_status FROM status ORDER BY nome_status";
        return $this->executarPesquisa($sql);
    }

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
