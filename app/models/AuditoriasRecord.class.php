<?php

class AuditoriasRecord extends ManipulaBanco {

    public function cadastrarAuditoria($dados) {
        return $this->salvar($dados);
    }

    public function atualizarAuditoria($dados, $codAuditoria) {
        return $this->atualizar($dados, $codAuditoria);
    }

    public function listarAuditorias() {
        $criteria = new TCriteria();
        return $this->selecionarColecao($criteria);
    }

    public function getRecurso($idAuditoria) {
        $criteria = new TCriteria();
        $criteria->add(new TFilter('cd_auditoria', '=', $idAuditoria));
        return $this->selecionar($criteria);
    }

}

?>
