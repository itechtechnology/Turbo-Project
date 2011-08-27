<?php
  abstract class ManipulaBanco extends TRecord
  {
  
    private function converteObjeto($objeto)
    {
        $dados = get_object_vars($objeto);

        return $dados;
    }

	private function geraString($dados)
	{
		if(is_object($dados))
		{
			$dados = $this->converteObjeto($dados);
		}

		foreach($dados as $coluna => $valor)
		{
			$this->$coluna = $valor;
		}
	}

    //TIPOS: 1 - NORMAL; 2 - COLECAO
    private function geraArray($result,$tipo)
    {
		if($tipo == 1)
        {
          $dados = $this->converteObjeto($result);

          foreach($dados['fields'] as $coluna => $valor)
          {
             if(is_string($coluna))
             {
               $coluna = strtoupper($coluna);
               $array[$coluna]['0'] = $valor;
             }
          }

          return $array;

        } else if($tipo == 2)
        {
           $cont = 0;
           
           foreach($result as $objeto)
           {
              $cont++;
              
              $dados = $this->converteObjeto($objeto);

              foreach($dados as $coluna => $valor)
              {
                 $array[$coluna][$cont] = $valor;
              }
           }
           
           return $array;
        } else
		{
			//ARRAY UTILIZADO NOS M�TODOS QUE GERAM A LISTAGEM DE COMPARA��O PARA OS LOGS
			$dados = $this->converteObjeto($result);

			foreach($dados['fields'] as $coluna => $valor)
		    {
				if(is_string($coluna))
				{
					$coluna = $coluna;
					$array[$coluna] = $valor;
				}
			}

			return $array;
		}
    }
      
    private function montaColecao()
    {
        TTransaction::open();
         
        $repository = new TRepository($this->getEntity());

        return $repository;
    }
      
    public function salvar($dados)
    {
        $this->geraString($dados);
       // print_r($dados);
        if($this->save())
        {
          return true;
        } else
        {
          return false;
        }
    }
      
    public function atualizar($dados,$id)
    {
        $this->geraString($dados);

        if($this->update($id))
        {
			return true;
        } else
        {
           return false;
        }
    }
      
    public function deletar(TCriteria $condicao)
    {
        $this->delete($condicao);
        $linhas = $this->numLinhas($condicao);

        if($linhas > 0)
        {
			return false;
        } else {
           return true;
        }
    }

    public function selecionar(TCriteria $condicao)
    {
        $rs = $this->load($condicao);
		$linhas = count($rs);

        if($linhas > 0)
        {
           return $this->geraArray($rs,1);
        } else
        {
           return false;
        }
    }

    public function selecionarColecao(TCriteria $condicao)
    {
        $repository = $this->montaColecao();
        $rs = $repository->load($condicao);
        $linhas = count($rs);
		 
        TTransaction::close();
         
        if($linhas > 0)
        {
           return $this->geraArray($rs,2);
        } else
        {
           return false;
        }
    }
      
    public function selecionarDistinto(TCriteria $condicao,$campo)
    {
        $repository = $this->montaColecao();
        $rs = $repository->loadDistinct($condicao,$campo);
        $linhas = count($rs);
         
        TTransaction::close();
         
        if($linhas > 0)
        {
           return $this->geraArray($rs,2);
        } else
        {
           return false;
        }
    }
	 
    public function ultimoId($sequencia = '',$sgbd = DBSGBD)
    {
		switch($sgbd)
		{
			case "mysql":
			{
				return $this->last_id();
				break;
			}
			
			case "postgres":
			{
				$sql = "SELECT CURRVAL('".$sequencia."') AS ultimoId";
				$result = $this->executarPesquisa($sql);
				 
				return $result['ULTIMOID']['1'];
				break;
			}
		}
    }
      
    public function numLinhas(TCriteria $condicao)
    {
        $repository = $this->montaColecao();

        return $repository->count($condicao);
         
        TTransaction::close();
    }
      
    public function somaCampos(TCriteria $condicao,$coluna)
    {
        $repository = $this->montaColecao();
         
        return $repository->sum($condicao,$coluna);

        TTransaction::close();
    }
    
	
		
    public function executarPesquisa($stringSql)
    {   
		try
      	{
      		TTransaction::open();
      		
      		$conn = TTransaction::get();
			 
            $result = $conn->Execute($stringSql);
             
      		TTransaction::close();
	    if(!$result)
            {
                throw new Exception('Erro ao Executar a Instru��o SQL !!');
            }
			elseif($result->FieldCount() > 0)
            { 
                while (!$result->EOF)
                {
					// armazena no array $results;
                    $results[] = $result->fetchObject($this->class . 'Record');
					
                    $result->moveNext();
                }
				
				$rs = $this->geraArray($results,2);
				 
				return $rs;
            }
      	} catch(exception $e)
      	{
      		TTransaction::rollback();	
      	}
    }
	  
	public function executar($stringSql)
	{ 
		try
      	{
      		TTransaction::open();
      		
      		$conn = TTransaction::get();
			 
            $result = $conn->Execute($stringSql);
             
			TTransaction::close();			
      		
			if(!$result)
            {
                throw new Exception('Erro ao Executar a Instru��o SQL !!');
            }else
            { 
				return true;
            }
      	} catch(exception $e)
      	{
      		TTransaction::rollback();	
      	}
	}
	  
	public function validarConexao($login,$senha)
	{ 
		return TConnection::open($login,$senha);
	}
  }
?>
