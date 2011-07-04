<?php

class RecursoFisicosRecord extends ManipulaBanco {

    public function cadastrarRecurso($dados) {
        return $this->salvar($dados);
    }

    public function atualizarRecurso($dados, $codRecurso) {
        return $this->atualizar($dados, $codRecurso);
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

    public function dadosRecurso($idRecurso) {
        $criteria = new TCriteria();
        $criteria->add(new TFilter('cd_recurso', '=', $idRecurso));
        return $this->selecionar($criteria);
    }

}

?>
