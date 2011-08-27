<?php

/**
 * Classe que representa um objeto tarefa 
 * Utilizada para manipular objetos do banco de dados
 * 
 * @package app
 * @subpackage models
 * @author Paavo Soeiro
 * 
 */
class TarefasRecord extends ManipulaBanco {

    /**
     * Metodo para inserir uma nova tarefa
     *
     * @param array $dados os dados da tarefa
     * @return boolean 
     */
    public function cadastrarTarefa($dados) {
        return $this->salvar($dados);
    }

    /**
     * Metodo para atualizar uma tarefa
     *
     * @param array $dados os dados a serem atualizados
     * @param int $codTarefa o id da tarfa
     * @return boolean
     */
    public function atualizarTarefa($dados, $codTarefa) {
        return $this->atualizar($dados, $codTarefa);
    }

    /**
     * Metodo para concluir uma tarefa, ou seja, atualiza o status para 6 (concluida)
     * 
     * @param int $codTarefa
     * @return boolean
     */
    public function concluirTarefa($codTarefa) {
        $sql = "UPDATE tarefa SET fk_cd_status = 6, dt_conclusao = '" .
                date('Y-m-d') . "', pcompleto = 100 WHERE cd_tarefa = " . $codTarefa;
        return $this->executar($sql);
    }

    /**
     * Metodo que seleciona uma tarefa
     *
     * @param int $cd_tarefa o id da tarefa
     * @return array com os dados da tarefa
     */
    public function getTarefa($cd_tarefa) {
        $criteria = new TCriteria();
        $criteria->add(new TFilter('cd_tarefa', '=', $cd_tarefa));
        return $this->selecionar($criteria);
    }

    /**
     * Metodo que seleciona tarefas no banco de dados
     *
     * @param string $texto string a ser pesquisada
     * @param string $ordCampo campo de ordenacao
     * @param string $SORT ordenacao ascendente, ou descendente
     * @return colecao tarefas selecionadas  
     */
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

    /**
     * Metodo que seleciona os colaboradores alocados numa tarefa especifica
     *
     * @param int $cd_tarefa id da tarefa
     * @return colecao colaboradores da tarefa 
     */
    public function getTarefaColaboradores($cd_tarefa) {
        $sql = "SELECT usuario.cd_usuario, usuario.nome, tipocargo.nome_tipo_cargo as cargo, tarefaalocarecursohumano.valor_hora, tarefa.nome_tarefa" .
                " FROM tipocargo, usuario, tarefaalocarecursohumano, tarefa" .
                " WHERE usuario.cd_usuario = tarefaalocarecursohumano.fk_cd_usuario AND tarefaalocarecursohumano.fk_cd_tipocargo = tipocargo.cd_tipo_cargo" .
                " AND tarefa.cd_tarefa = tarefaalocarecursohumano.fk_cd_tarefa" .
                " and tarefaalocarecursohumano.fk_cd_tarefa = " . $cd_tarefa;
        return $this->executarPesquisa($sql);
    }

    /**
     * Metodo que seleciona as tarefas de um projeto
     *
     * @param int $cd_projeto id do projeto
     * @return colecao tarefas de um projeto 
     */
    public function getTarefasProjeto($cd_projeto) {
        $sql = "select * from tarefa where fk_cd_projeto = " . $cd_projeto;
        return $this->executarPesquisa($sql);
    }

    /**
     * Metodo que seleciona tarefas iniciadas
     *
     * @return colecao tarefas iniciadas 
     */
    public function getTarefasIniciadas() {
        $sql = "SELECT tarefa.cd_tarefa, tarefa.nome_tarefa" .
                " FROM tarefa  WHERE fk_cd_status = 1 OR fk_cd_status = 4" .
                " ORDER BY nome_tarefa";
        return $this->executarPesquisa($sql);
    }

    /**
     * Metodo que seleciona tarefas em atraso
     *
     * @return colecao tarefas em atraso 
     */
    public function getTarefasEmAtraso() {
        $sql = "SELECT * FROM vtarefasematraso";
        return $this->executarPesquisa($sql);
    }

    /**
     * Metodo que atualiza o status de uma tarefa para 5 (atrasada)
     *
     * @param int $cd_tarefa id da tarefa
     */
    public function setStatusAtrasada($cd_tarefa) {
        $sql = "UPDATE tarefa SET fk_cd_status = 5 WHERE cd_tarefa = " . $cd_tarefa;
        $this->executar($sql);
    }

    /**
     * Este metodo talvez seja um dos mais importantes do sistema
     * ele é responsavel por atualizar o status de tarefas atrasadas e enviar
     * uma mensagem ao responsavel pela tarefa, avisando sobre o atraso.
     * 
     * @static
     */
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

    /**
     * Metodo que seleciona todas as subtarefas de uma tarefa especifica
     *
     * @param int $cd_tarefa id da tarefa
     * @return colecao subtarefas 
     */
    public function getSubTarefas($cd_tarefa) {
        $sql = "select * from tarefa where fk_cd_tarefa = " . $cd_tarefa;
        return $this->executarPesquisa($sql);
    }

    /**
     * Metodo que seleciona uma tarefa e seu responsavel
     *
     * @param int $cd_tarefa id da tarefa
     * @return colecao tarefa  
     */
    public function getTarefaResponsavel($cd_tarefa) {
        $sql = "SELECT * FROM vtarefaresponsavel WHERE cd_tarefa = " . $cd_tarefa;
        return $this->executarPesquisa($sql);
    }

}

?>
