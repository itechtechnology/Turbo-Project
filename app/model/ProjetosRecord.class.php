<?php
    /**
     * Classe Genérica para manipulação dos registros da tabela (Entidade) Projeto
     *
     * @author: Anderson Rodrigues
     * @name: ProjetoRecord
     * Data: 13/05/2011
     * @version: 1.0.0.35
     * Modificada: 27/05/2011
     * Descrição: Classe genérica para manipulação de registros de projetos no banco.
     */
	class ProjetosRecord extends ManipulaBanco
	{
                /**
                 * Método que recebe uma array de valores e insere como um registro no banco
                 *
                 * @param <array> $dados dados do registro a ser inserido
                 * @return <boolean> return true para ok ou false para erro
                 */
		public function cadastrarProjetos($dados)

		{

                    	return $this->salvar($dados);

		}


                /**
                 * Método que Atualiza os valores de um registro no banco de dados
                 *
                 * @param <array> $dados vetor com dados a serem atualizados
                 * @param <int> $codProjetos indentificador
                 * @return <boolean>
                 */
		public function atualizarProjetos($dados,$codProjetos)

		{

			return $this->atualizar($dados,$codProjetos);

		}


                /**
                 * Método que exclui um registro da tabela projeto
                 *
                 * @param <int> $codProjetos código do registro a ser excluido
                 * @return <boolean> retorno true para ok e false para erro
                 */
		public function excluirProjetos($codProjetos)

		{

			$criteria = new TCriteria();

			$criteria->add(new TFilter('cd_projeto','=',$codProjetos));



			return $this->deletar($criteria);

		}


                /**
                 * Método que retorna em um array os dados de um determinado projeto
                 *
                 * @param <int> $cd_projeto codigo do projeto a ser pesquisado
                 * @return <array> array contendo os dados da tabela projeot
                 */
                public function dadosProjeto($cd_projeto)
		{
			$criteria = new TCriteria();
			$criteria->add(new TFilter('cd_projeto','=',$cd_projeto));

			return $this->selecionar($criteria);
		}


                /**
                 * Método que irá retonrar um projeto pelo seu id
                 *      semelhante a dadosProjeto no entanto segue uma
                 *      nomeclatura mais clássica
                 *
                 * @param <type> $id = id do projeto a ser pesquisado
                 * @return <array> dados do projeto
                 */
                public function getProjetoByID($id)
                {
                    return dadosProjeto($id);
                }


                /** METÓDO QUE IRÁ RETORNAR DADOS COMPLETOS DE UM PROJETO PELO ID
                 *  este método faz uso de uma visão para retornar outros dados
                 *  além dos proprios da classe projeto
                 *
                 * @param <int> $id id do projeto a ser pesquisado
                 * @return <array> dados completos do projeto incluindo status, gerente...
                 */
                public function getProjetoCompletoByID($id)
                {
                    $lib = new Lib();
                    $sql = "SELECT * FROM vprojetocompleto WHERE cd_projeto = ".
                    $lib->antiInjection($id);
                    
                    $projetos = $this->executarPesquisa($sql);
                    
                    return $projetos;
                }

                
                 /** METODO QUE IRÁ RETORNAR UMA LISTAGEM FILTRADA
                 *
                 * @param <string> $texto texto a ser pesquisado
                 * @param <string> $ordCampo campo de ordenação
                 * @param <string> $SORT tipo ordenção ASC ou DESC
                 * @return <array> array contendo o resultado
                 */
                public function getProjetos($texto="", $ordCampo="", $SORT="")
                {
                        $sql = "SELECT cd_projeto, nome_projeto, nome_status as status, nome as gerente ".
                            " FROM vprojetocompleto ";

                        if  (!empty($texto))
                        {
                        $sql .= " WHERE nome_projeto LIKE '%".$texto."%' ";
                        }

                        if (!empty($ordCampo))
                        {
                            $sql .= " ORDER BY ".$ordCampo." ".$SORT;
                        }

                        $projetos =  $this->executarPesquisa($sql);
                       
                        return $projetos;

                }


                 /** METODO QUE IRÁ RETORNAR UMA LISTAGEM FILTRADA
                 * faz uso de uma visão para retornar dados mais completos
                 *
                 * @param <string> $texto texto a ser pesquisado
                 * @param <string> $ordCampo campo de ordenação
                 * @param <string> $SORT tipo ordenção ASC ou DESC
                 * @return <array> array contendo o resultado
                 */
                public function getProjetoCompleto($texto="", $ordCampo="", $SORT="")
                {
                        $sql = "SELECT * FROM vprojetocompleto ";

                        if  (!empty($texto))
                        {
                        $sql .= " WHERE nome_projeto LIKE '%".$texto."%' ";
                        }

                        if (!empty($ordCampo))
                        {
                            $sql .= " ORDER BY ".$ordCampo." ".$SORT;
                        }

                        $projetos =  $this->executarPesquisa($sql);

                        return $projetos;

                }


                /** METÓDO SUPER GENERICO QUE RETORNA TODOS OS REGISTRO DE PROJETOS
                 *
                 * @return <array> array de dados com os dados da tabela projetos
                 */
                public function listarProjetos()
		{

			$criteria = new TCriteria();

			return $this->selecionarColecao($criteria);

		}

                /**
                 * METODO RETORNARÁ UMA LISTA DE TODOS OS PROJETOS E SEUS GERNENTES
                 */
                public function listarProjetosGerente()
                {
                    $sql = "SELECT * ".
                            "FROM vprojetocompleto".
                            "WHERE CD_CARGO IN (0,1)";
                    $projetos =  $this->executarPesquisa($sql);
                    
                    return $projetos;
                }
	}

?>
             