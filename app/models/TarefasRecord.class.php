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

    public function concluirTarefa($codTarefa) {
        $sql = "UPDATE tarefa SET fk_cd_status = 6, dt_conclusao = '" .
                date('Y-m-d') . "', pcompleto = 100 WHERE cd_tarefa = " . $codTarefa;
        return $this->executar($sql);
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
        $sql = "SELECT usuario.cd_usuario, usuario.nome, tipocargo.nome_tipo_cargo as cargo, tarefaalocarecursohumano.valor_hora, tarefa.nome_tarefa" .
                " FROM tipocargo, usuario, tarefaalocarecursohumano, tarefa" .
                " WHERE usuario.cd_usuario = tarefaalocarecursohumano.fk_cd_usuario AND tarefaalocarecursohumano.fk_cd_tipocargo = tipocargo.cd_tipo_cargo" .
                " AND tarefa.cd_tarefa = tarefaalocarecursohumano.fk_cd_tarefa" .
                " and tarefaalocarecursohumano.fk_cd_tarefa = " . $cd_tarefa;
        return $this->executarPesquisa($sql);
    }

    public function getTarefasProjeto($cd_projeto) {
//        $criteria = new TCriteria();
//        $criteria->add(new TFilter("fk_cd_projeto", "=", $cd_projeto));
//        return $this->selecionar($criteria);
        $sql = "select * from tarefa where fk_cd_projeto = " . $cd_projeto;
        return $this->executarPesquisa($sql);
    }

    public function getTarefasIniciadas() {
        $sql = "SELECT tarefa.cd_tarefa, tarefa.nome_tarefa" .
                " FROM tarefa  WHERE fk_cd_status = 1 OR fk_cd_status = 4" .
                " ORDER BY nome_tarefa";
        return $this->executarPesquisa($sql);
    }

    public function getTarefasEmAtraso() {
        $sql = "SELECT * FROM vtarefasematraso";
        return $this->executarPesquisa($sql);
    }

    public function setStatusAtrasada($cd_tarefa) {
        $sql = "UPDATE tarefa SET fk_cd_status = 5 WHERE cd_tarefa = " . $cd_tarefa;
        $this->executar($sql);
    }

    public static function atualizarTarefas() {
        $mensagem = new MensagemsRecord();
        $tarefasAtrasadas = $this->getTarefasEmAtraso();
        for ($i = 1; $i <= count($tarefasAtrasadas['CD_TAREFA']); $i++) {
            $this->setStatusAtrasada($tarefasAtrasadas['CD_TAREFA'][$i]);
            $dados['remetente'] = 32;
            $dados['destinatario'] = $tarefasAtrasadas['RESPONSAVEL'][$i];
            $dados['texto'] = "A Tarefa " . $tarefasAtrasadas['NOME_TAREFA'][$i] .
                    "está em atraso.<br/>" .
                    "Verifique-a no link <a href=\"www.itech10.com/app/views/tarefa.php?tarefa=" .
                    $tarefasAtrasadas['CD_TAREFA'][$i] .
                    " \">Visualizar Tarefa</a>";
            $dados['titulo'] = "Tarefa em atraso!";
            $mensagem->salvar($dados);
        }
    }

    public function getSubTarefas($cd_tarefa) {
        $sql = "select * from tarefa where fk_cd_tarefa = " . $cd_tarefa;
        return $this->executarPesquisa($sql);
    }

    public function getTarefaResponsavel($cd_tarefa) {
        $sql = "SELECT * FROM vtarefaresponsavel WHERE cd_tarefa = " . $cd_tarefa;
        return $this->executarPesquisa($sql);
    }

}

?>
