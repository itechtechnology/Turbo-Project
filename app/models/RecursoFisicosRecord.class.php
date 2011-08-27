<?php

/**
 * Classe que representa um objeto recurso fisico 
 * Utilizada para manipular objetos do banco de dados
 * 
 * @package app
 * @subpackage models
 * @author Paavo Soeiro
 * 
 */
class RecursoFisicosRecord extends ManipulaBanco {
    
    /**
     * Metodo que insere um novo recurso fisico no banco de dados
     * 
     * @param array $dados
     * @return boolean 
     */
    public function cadastrarRecurso($dados) {
        return $this->salvar($dados);
    }

    /**
     * Metodo que atualiza um registro de recurso no banco de dados
     *
     * @param array $dados
     * @param int $codRecurso
     * @return boolean 
     */
    public function atualizarRecurso($dados, $codRecurso) {
        return $this->atualizar($dados, $codRecurso);
    }

    /**
     * Metodo que atualiza o status de um recurso no banco de dados
     *
     * @param int $codRecurso
     * @return boolean 
     */
    public function atualizarStatus($codRecurso) {
        $sql = "UPDATE recursofisico SET fk_cd_statusrecurso = 2 WHERE cd_recurso = " . $codRecurso;
        return $this->executar($sql);
    }

    /**
     * Metodo que lista recursos
     *
     * @param string $ordCampo
     * @param string $ordType
     * @return colecao 
     */
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

    /**
     * Metodo que retorna um recurso
     *
     * @param int $recurso
     * @param string $ordCampo
     * @param string $ordType
     * @return recurso 
     */
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

    /**
     * Metodo que retorna uma colecao de recursos
     *
     * @param string $texto
     * @param string $ordCampo
     * @param string $SORT
     * @return colecao 
     */
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

    /**
     * Metodo para selecionar os dados de um recurso
     *
     * @param int $idRecurso
     * @return array 
     */
    public function dadosRecurso($idRecurso) {
        $criteria = new TCriteria();
        $criteria->add(new TFilter('cd_recurso', '=', $idRecurso));
        return $this->selecionar($criteria);
    }

    /**
     * Metodo para selecionar os recursos fisicos disponiveis
     *
     * @return colecao 
     */
    public function getRecursosFisicosDisponiveis() {
        $sql = 'select * from recursofisico where fk_cd_statusrecurso = 1';
        return $this->executarPesquisa($sql);
    }

    /**
     * Metodo que seleciona recursos alocados numa determinada tarefa
     *
     * @param int $cd_tarefa
     * @return colecao
     */
    public function getRecursosAlocados($cd_tarefa) {
        $sql = "select cd_recurso, nome_recurso, custo, dt_aloca_recurso, dt_devolucao_recurso from" .
                " recursofisico join tarefaalocarecursofisico on cd_recurso = fk_cd_recurso" .
                " where fk_cd_tarefa = " . $cd_tarefa;
        return $this->executarPesquisa($sql);
    }

}

?>
