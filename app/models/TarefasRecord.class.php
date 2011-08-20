<?php

/**
 * Description of TarefasRecord
 *
 * @author Paavo Soeiro
 */
class TarefasRecord extends ManipulaBanco {

    public function cadastrarTarefa($dados) {
        return $this->salvar($dados);
    }

    public function atualizarTarefa($dados, $codTarefa) {
        return $this->atualizar($dados, $codTarefa);
    }

    public function getTarefa($cd_tarefa) {
        $criteria = new TCriteria();
        $criteria->add(new TFilter('cd_tarefa', '=', $cd_tarefa));
        return $this->selecionar($criteria);
    }

    public function getTarefas($texto="", $ordCampo="", $SORT="") {
        $sql = "SELECT * FROM vtarefastatus";

        if (!empty($texto)) {
            $sql .= " WHERE nome_tarefa LIKE '%" . $texto . "%' ";
        }

        if (!empty($ordCampo)) {
            $sql .= " ORDER BY " . $ordCampo . " " . $SORT;
        }

        return $this->executarPesquisa($sql);
    }

    public function getTarefaColaboradores($cd_tarefa) {
        $sql = "SELECT usuario.nome, tipocargo.nome_tipo_cargo as cargo, tarefaalocarecursohumano.valor_hora, tarefa.nome_tarefa" .
                " FROM tipocargo, usuario, tarefaalocarecursohumano, tarefa" .
                " WHERE usuario.cd_usuario = tarefaalocarecursohumano.fk_cd_usuario AND tarefaalocarecursohumano.fk_cd_tipocargo = tipocargo.cd_tipo_cargo" .
                " AND tarefa.cd_tarefa = tarefaalocarecursohumano.fk_cd_tarefa" .
                " and tarefaalocarecursohumano.fk_cd_tarefa = " . $cd_tarefa;
        return $this->executarPesquisa($sql);
    }

}

?>
