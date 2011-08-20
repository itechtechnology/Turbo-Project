<?php

/**
  @date: 17/08/2011
  @Author: Anderson Rodrigues

  @descripition: CLASSE RESPONSAVEL POR GERAR AUDITORIAS

 */
class AuditoriasRecord extends ManipulaBanco {

public function cadastrarAuditoria($dados) {
return $this->salvar($dados);
}
//@TODO TENHO DE IMPLEMENTAR O METODO GERA AUDITORIA pegar o usuario
public function atualizarAuditoria($dados, $codAuditoria) {
return $this->atualizar($dados, $codAuditoria);
}

public function listarAuditorias() {
$criteria = new TCriteria();
return $this->selecionarColecao($criteria);
}

public function getAuditoria($idAuditoria) {
$criteria = new TCriteria();
$criteria->add(new TFilter('cd_auditoria', '=', $idAuditoria));
return $this->selecionar($criteria);
}

}
?>
