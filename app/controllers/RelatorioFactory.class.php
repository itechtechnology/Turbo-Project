<?php

/**
 * Classe responsavel por gerenciar os relatorios
 * 
 * @package app
 * @subpackage controllers
 * @author Paavo Soeiro
 */
require_once '../../jqgrid/jq-config.php';
// include the jqGrid Class
require_once ABSPATH . "php/jqGrid.php";
// include the driver class
require_once ABSPATH . "php/jqGridPdo.php";
require_once ABSPATH . "php/jqAutocomplete.php";

/**
 * Classe responsavel por gerenciar os relatorios
 *
 * @package app
 * @subpackage controllers
 * @author Paavo Soeiro
 */
class RelatorioFactory {

    /**
     * Variavel de conexao do banco de dados
     * 
     *
     * @var PDO 
     * @access private
     */
    private $conn;

    /**
     * Variavel do renderizador de relatorios
     *
     * @var jqGridRender
     * @access private 
     */
    private $grid;

    /**
     * Metodo construtor
     */
    public function __construct() {
        $this->conn = new PDO('pgsql:host=localhost dbname=itechcom_turbo user=itechcom password=itechuesc123');
        $this->grid = new jqGridRender($this->conn);
        $this->grid->dataType = 'json';
    }

    /**
     * Metodo que gera o relatorio
     * 
     * @param GET $relatorio 
     */
    public function gerarRelatorio($relatorio) {
        switch ($relatorio) {
            case 'recurso': {
                    $this->grid->SelectCommand = 'SELECT cd_recurso, nome_recurso, ds_recurso, custo, nome_statusrecurso FROM vrecursostatus';
                    $this->grid->ExportCommand = 'SELECT cd_recurso, nome_recurso, ds_recurso, custo, nome_statusrecurso FROM vrecursostatus';
//            $export = $_POST['oper'];
//            if ($export == 'excel') {
//                // let set summary field
////                $grid->exportToPdf(array('recurso' => 'nome_recurso'));
//                $grid->exportToExcel(array('recurso' => 'nome_recurso'));
//            } else {
//                $grid->queryGrid();
                    $export = $_POST['oper'];

                    if ($export == 'pdf')
                    // let set summary field
                        $this->grid->exportToPdf(array('recurso' => 'nome_recurso'));
                    else
                        $this->grid->queryGrid();
//            }
                    break;
                }
            case 'usuarioshabilidades': {
                    $this->grid->SelectCommand = 'SELECT usuario.nome as usuario, habilidade.nome as habilidade FROM habilidade JOIN  usuariohabilidade ON habilidade.cd_habilidade = usuariohabilidade.fk_cd_habilidade JOIN usuario ON usuariohabilidade.fk_cd_usuario = usuario.cd_usuario';
//            $grid->setAutocomplete("usuario", false, "SELECT DISTINCT usuario.nome as usuario, habilidade.nome as habilidade FROM habilidade JOIN  usuariohabilidade ON habilidade.cd_habilidade = usuariohabilidade.fk_cd_habilidade JOIN usuario ON usuariohabilidade.fk_cd_usuario = usuario.cd_usuario WHERE usuario.nome LIKE ? ORDER BY usuario.nome", null, false, true);
                    $this->grid->queryGrid();
                    break;
                }
            case 'usuarios': {
                    $this->grid->SelectCommand = 'SELECT usuario.cd_usuario, usuario.nome, usuario.login FROM usuario';
                    $oper = $_POST['oper'];
                    if ($oper == 'edit') {
                        $this->grid->table = 'usuario';
                        $this->grid->setPrimaryKeyId('cd_usuario');
                        $data = $_POST;
                        $this->grid->update($data);
                    } else {
                        $this->grid->queryGrid();
                    }
                    break;
                }
            case 'projetos': {
                    $this->grid->SelectCommand = "SELECT projeto.cd_projeto, projeto.nome_projeto, tarefa.nome_tarefa," .
                            " status.nome_status" .
                            " FROM public.projeto JOIN" .
                            " public.tarefa ON tarefa.fk_cd_projeto = projeto.cd_projeto JOIN" .
                            " public.status ON status.cd_status = tarefa.fk_cd_status"
//                            .
//                            " ORDER BY nome_projeto, nome_tarefa"
                    ;
                    $this->grid->queryGrid();
                    break;
                }
        }
    }

}

?>
