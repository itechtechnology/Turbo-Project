<?php

class RecursosRecord extends ManipulaBanco {

    public function cadastrarRecurso($dados) {
        return $this->salvar($dados);
    }

    public function atualizarRecurso($dados, $codRecurso) {
        return $this->atualizar($dados, $codRecurso);
    }

    public function listarRecurso() {
        $criteria = new TCriteria();
        return $this->selecionarColecao($criteria);
    }
    
    public function getRecurso($idRecurso){
        $criteria = new TCriteria();
        $criteria->add(new TFilter('id_recurso', '=', $idRecurso));
        return $this->selecionar($criteria);
    }

}

?>
