<?php

class RecursoFisicosRecord extends ManipulaBanco {

    public function cadastrarRecurso($dados) {
        return $this->salvar($dados);
    }

    public function atualizarRecurso($dados, $codRecurso) {
        return $this->atualizar($dados, $codRecurso);
    }

    public function atualizarStatus($codRecurso) {
        $sql = "UPDATE recursofisico SET fk_cd_statusrecurso = 2 WHERE cd_recurso = " . $codRecurso;
        return $this->executar($sql);
    }

    public function listarRecurso($ordCampo = '', $ordType = '') {
        $criteria = new TCriteria();

        if (!empty($ordCampo)) {
            $criteria->setProperty('order', $ordCampo);
        }

        if (!empty($ordType)) {
            $criteria->setProperty('type', $ordType);
        }

        return $this->selecionarColecao($criteria);
    }

    public function getRecurso($recurso, $ordCampo = '', $ordType = '') {
        $criteria = new TCriteria();
        $criteria->add(new TFilter('nome_recurso', 'LIKE', $recurso . '%'));

        if (!empty($ordCampo)) {
            $criteria->setProperty('order', $ordCampo);
        }

        if (!empty($ordType)) {
            $criteria->setProperty('type', $ordType);
        }

        return $this->selecionarColecao($criteria);
    }

    public function getRecursos($texto="", $ordCampo="", $SORT="") {
        $sql = "SELECT * FROM vrecursostatus";

        if (!empty($texto)) {
            $sql .= " WHERE nome_recurso LIKE '%" . $texto . "%' ";
        }

        if (!empty($ordCampo)) {
            $sql .= " ORDER BY " . $ordCampo . " " . $SORT;
        }

        return $this->executarPesquisa($sql);
    }

    public function dadosRecurso($idRecurso) {
        $criteria = new TCriteria();
        $criteria->add(new TFilter('cd_recurso', '=', $idRecurso));
        return $this->selecionar($criteria);
    }

    public function getRecursosFisicosDisponiveis() {
        $sql = 'select * from recursofisico where fk_cd_statusrecurso = 1';
//        $criteria = new TCriteria();
//        $criteria->add(new TFilter('fk_cd_statusrecurso', '=', '1'));
//        return $this->selecionar($criteria);
        return $this->executarPesquisa($sql);
    }

    public function getRecursosAlocados($cd_tarefa) {
        $sql = "select cd_recurso, nome_recurso, custo, dt_aloca_recurso, dt_devolucao_recurso from" .
                " recursofisico join tarefaalocarecursofisico on cd_recurso = fk_cd_recurso" .
                " where fk_cd_tarefa = " . $cd_tarefa;
        return $this->executarPesquisa($sql);
    }

}

?>
