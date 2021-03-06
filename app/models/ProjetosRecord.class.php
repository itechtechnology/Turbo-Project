<?php

/**
 * Classe genericá para manipulação de registros de projetos no banco.
 * 
 * @package app
 * @subpackage models
 * @author Anderson Rodrigues
 * @since 13/05/2011
 */
class ProjetosRecord extends ManipulaBanco {

    public function cadastrarProjetos($dados) {
        /*
         * aki eu atualizo a chave primaria
         * talvez seja necessario retirar caso o gatilho
         * seja adicionado
         */

        //$dados['cd_projeto'] = $this->ultimoId('projeto_cd_projeto_seq', 'pgsql');// $result['ULTIMOID']['1'];

        return $this->salvar($dados);
    }

    public function atualizarProjetos($dados, $codProjetos) {

        return $this->atualizar($dados, $codProjetos);
    }

    public function excluirProjetos($codProjetos) {

        $criteria = new TCriteria();

        $criteria->add(new TFilter('cd_projeto', '=', $codProjetos));



        return $this->deletar($criteria);
    }

    /**
     * METODO QUE RETORNO DOS DADOS DE UM DETERMINADO PROJETO
     * 
     * @param int $cd_projeto codigo do projeto a ser pesquisado
     * @return array array contendo os dados da tabela projeto
     */
    public function dadosProjeto($cd_projeto) {
//        $criteria = new TCriteria();
//        $criteria->add(new TFilter('cd_projeto', '=', $cd_projeto));
//
//        return $this->selecionar($criteria);
        $sql = "SELECT * FROM projeto where cd_projeto = " . $cd_projeto;
        return $this->executarPesquisa($sql);
    }

    /** METÓDO QUE IRÁ RETORNAR UM PROJETO PELO ID
     *
     * @param int $id  id do projeto a ser pesquisado
     * @return objeto projeto
     */
    public function getProjetoByID($id) {
        return dadosProjeto($id);
    }

    /** METÓDO QUE IRÁ RETORNAR DADOS COMPLETO DE UM PROJETO PELO ID
     *
     * @param int $id = id do projeto a ser pesquisado
     * @return array dados completos do projeto incluindo status gerente...
     */
    public function getProjetoCompletoByID($id) {
        $lib = new Lib();
        $sql = "SELECT * FROM vprojetocompleto WHERE cd_projeto = " .
                $lib->antiInjection($id);

        $projetos = $this->executarPesquisa($sql);

        //echo $sql;
        //print_r($projetos);

        return $projetos;
    }

    /** METODO QUE IRÁ RETORNAR UMA LISTAGEM FILTRADA
     *
     * @param <string> $texto texto a ser pesquisado
     * @param <string> $ordCampo campo de ordenação
     * @param <string> $SORT tipo ordenção ASC ou DESC
     * @return <array de dados> array contendo o resultado
     */
    public function getProjetoCompleto($texto="", $ordCampo="", $SORT="") {
        $sql = "SELECT * FROM vprojetocompleto ";

        if (!empty($texto)) {
            $sql .= " WHERE nome_projeto LIKE '%" . $texto . "%' ";
        }

        if (!empty($ordCampo)) {
            $sql .= " ORDER BY " . $ordCampo . " " . $SORT;
        }

        $projetos = $this->executarPesquisa($sql);

        return $projetos;
    }

    /** METODO QUE IRÁ RETORNAR UMA LISTAGEM FILTRADA
     *
     * @param <string> $texto texto a ser pesquisado
     * @param <string> $ordCampo campo de ordenação
     * @param <string> $SORT tipo ordenção ASC ou DESC
     * @return <array de dados> array contendo o resultado
     */
    public function getProjetos($texto="", $ordCampo="", $SORT="") {
        $sql = "SELECT DISTINCT  nome_projeto, cd_projeto, nome_status as status, nome as gerente " .
                " FROM vprojetos ";

        if (!empty($texto)) {
            $sql .= " WHERE nome_projeto LIKE '%" . $texto . "%' ";
        }

        if (!empty($ordCampo)) {
            $sql .= " ORDER BY " . $ordCampo . " " . $SORT;
        }

        $projetos = $this->executarPesquisa($sql);

        return $projetos;
    }

    public function listarProjetos() {

        $criteria = new TCriteria();
        return $this->selecionarColecao($criteria);
    }

    public function listarProjetosIniciados() {
        $criteria = new TCriteria(new TFilter("fk_cd_status", "=", 1));
        $sql = "select * from projeto where fk_cd_status = 1";
        $projetos = $this->executarPesquisa($sql);

        return $projetos;
    }

}

?>
             