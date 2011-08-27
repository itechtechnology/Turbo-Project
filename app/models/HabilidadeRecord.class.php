<?php

/**
 * Classe Habilidade - Habilidades de um usuario
 * 
 * @package app
 * @subpackage models
 * @author Marcos Rosa
 * @since 07/05/11
 */
class HabilidadeRecord extends ManipulaBanco {

    //Variáveis que compõem o objeto
    private $id;
    private $nome;
    private $descricao;
    private $data_cadastro;

    function __construct() {
        
    }

    /**
     * Retorna as habilidades cadastradas
     * 
     * @return colecao 
     */
    function listaHabilidades() {
        $sql = "SELECT * FROM habilidade;";
        $result = $this->executarPesquisa($sql);
        return $result;
    }

    function construtor($id, $nome, $descricao, $data_cadastro) {

        $this->id = $id;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->data_cadastro = $data_cadastro;
    }

    /**
     * Insere um objeto habilidade no banco de dados
     */
    function insert() {
        include_once 'usuario/Conexao.class.php';

        date_default_timezone_set('America/Sao_Paulo');
        $data_hora = date("Y-m-d H:i:s"); //Dara do cadastro		 	

        $sql = "INSERT INTO habilidade VALUES (nextval('habilidade_cd_habilidade_seq'::regclass), '$this->descricao',  '$this->nome', '$data_hora');";

        $minhaConexao = new Conexao(); //Crio uma conexão
        $minhaConexao->envia_sql($sql); //Envio a SQL
        //Altero o id para o valor atual da sequência
        $sql = "SELECT last_value FROM habilidade_cd_habilidade_seq;";
        $r = $minhaConexao->envia_sql($sql); //Envio a SQL
        $row = pg_fetch_array($r);
        $this->id = $row[0];
    }

    //gets e sets 
    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->nome = $id;
    }

    function getNome() {
        return $this->nome;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function getDescricao() {
        return $this->Descricao;
    }

    function setDescricao($Descricao) {
        $this->Descricao = $Descricao;
    }

    /**
     * Recebe um id e retorna a habilidade correspondente
     * 
     * @param int $id
     * @return array 
     */
    function getHabilidade($id) {
        $sql = "SELECT nome FROM habilidade WHERE cd_habilidade = '$id';";
        $result = $this->executarPesquisa($sql);

        return $result['NOME'][1];
    }

}

?>