<?php

/**
 * CLASSE RESPONSAVEL POR GERAR AUDITORIAS
 * 
 * @package app
 * @subpackage models
 * @author Anderson Rodrigues
 * @since 17/08/2011
 */
class AuditoriasRecord extends ManipulaBanco {

    /**
     * Metodo para inserir auditoria
     * 
     * @param array $dados os dados da auditoria
     * @return boolean 
     */
    public function cadastrarAuditoria($dados) {
        return $this->salvar($dados);
    }

    /**
     * @todo TENHO DE IMPLEMENTAR O METODO GERA AUDITORIA pegar o usuario
     */
    
    /**
     * Metodo para atualizar a auditoria
     * 
     * @param array $dados dados a serem atualizados
     * @param int $codAuditoria id da auditoria
     * @return boolean
     */
    public function atualizarAuditoria($dados, $codAuditoria) {
        return $this->atualizar($dados, $codAuditoria);
    }
    
    /**
     * Metodo que lista auditorias
     *
     * @return boolean 
     */
    public function listarAuditorias() {
        $criteria = new TCriteria();
        return $this->selecionarColecao($criteria);
    }

    /**
     * Metodo que seleciona uma auditoria
     *
     * @param int $idAuditoria id da auditoria
     * @return array auditoria 
     */
    public function getAuditoria($idAuditoria) {
        $criteria = new TCriteria();
        $criteria->add(new TFilter('cd_auditoria', '=', $idAuditoria));
        return $this->selecionar($criteria);
    }

}

?>
