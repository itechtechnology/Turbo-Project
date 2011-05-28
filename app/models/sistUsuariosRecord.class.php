<?php
	class sistUsuariosRecord extends ManipulaBanco
	{
		public function cadastrarUsuarios($dados,$senha,$perfil,$acessa)
		{
			if($this->salvar($dados))
			{
				//CRIANDO A ROLE DE LOGIN
				$sql = "CREATE USER ".$dados['login'];
				
				if($dados['administrador'] == '1')
				{
					$sql .= " SUPERUSER";
				}
				
				$sql .= " ENCRYPTED PASSWORD '".$senha."'";
				
				if($acessa == 0)
				{
					$sql .= " NOLOGIN";
				}
				
				if($dados['duracao'] == '1')
				{
					$sql .= " VALID UNTIL '".$dados['validade']." 00:00:00'";
				}
				
				if($this->executar($sql))
				{
					return $this->concederPrivilegio($perfil,$dados['login']);
				} else
				{
					return false;
				}
			} else
			{
				return false;
			}
		}

		public function atualizarUsuarios($dados,$codUsuario,$senha,sistPerfisRecord $objPerfil,Lib $objLib)
		{
			//DADOS DO USUÁRIO
			$dadosAntigos = $this->dadosUsuario($codUsuario);
				
			if($this->atualizar($dados,$codUsuario))
			{	
				if($dados['administrador'] == '1')
				{
					$this->concederSuperUsuario($dadosAntigos['LOGIN']['0']);
				} else
				{
					$this->concederSuperUsuario($dadosAntigos['LOGIN']['0'],'0');
				}
				
				//ATUALIZANDO A SENHA
				if(!empty($senha))
				{
					$this->alterarSenha($senha,$dadosAntigos['LOGIN']['0'],$dadosAntigos['DURACAO']['0'],$objLib,'0');
					
					//ATUALIZANDO A VALIDADE
					$this->alterarValidadeSenha($dadosAntigos['LOGIN']['0'],$dados['duracao'],$dados['validadesenha']);
				}
			
				//ATUALIZANDO O PERFIL
				if($dados['perfil'] != $dadosAntigos['PERFIL']['0'])
				{
					//REVOGANDO O PERFIL ANTIGO
					$perfilAntigo = $objPerfil->dadosPerfil($dadosAntigos['PERFIL']['0']);
					$this->concederPrivilegio($perfilAntigo['NOME']['0'],$dadosAntigos['LOGIN']['0'],'0');
					
					//CONCEDENDO O PERFIL NOVO
					$perfilNovo = $objPerfil->dadosPerfil($dados['perfil']);
					$this->concederPrivilegio($perfilNovo['NOME']['0'],$dadosAntigos['LOGIN']['0']);
				}
				
				//ATUALIZANDO O STATUS
				if($dados['situacao'] != $dadosAntigos['SITUACAO']['0'])
				{
					$statusAntigo = $objStatus->dadosStatusUsuario($dadosAntigos['SITUACAO']['0']);
					
					$statusNovo = $objStatus->dadosStatusUsuario($dados['situacao']);
					
					if($statusAntigo['ACESSASISTEMA']['0'] != $statusNovo['ACESSASISTEMA']['0'])
					{
						$this->concederLogin($dadosAntigos['LOGIN']['0'],$statusNovo['ACESSASISTEMA']['0']);
					}
				}
				
				return true;
				
			} else
			{
				return false;
			}
		}
		
		/*
			ESTE MÉTODO SÓ DEVE SER UTILIZADO QUANDO FOR CHAMADO POR FORMULÁRIO QUE NÃO MODIFIQUEM:
			 -> PERFIL, STATUS
			EX.: ALTERAR SENHA (MÉTODO DESTA CLASSE), MODIFICAR DADOS CADASTRAIS (FORMULÁRIO UTILIZADO PELOS USUÁRIOS NORMAIS)
		*/
		
		public function atualizarUsuariosSemValidacao($dados,$codUsuario)
		{
			return $this->atualizar($dados,$codUsuario);
		}

		public function excluirUsuarios($codUsuarios)
		{
			$criteria = new TCriteria();
			$criteria->add(new TFilter('cod','=',$codUsuarios));

			return $this->deletar($criteria);
		}

		public function listarUsuarios($ordCampo = '',$ordType = '')
		{
			$criteria = new TCriteria();
			
			if(!empty($ordCampo))
			{
				$criteria->setProperty('order',$ordCampo);
			}
			
			if(!empty($ordType))
			{
				$criteria->setProperty('type',$ordType);
			}
			
			return $this->selecionarColecao($criteria);
		}
		
		public function dadosUsuario($codUsuario)
		{
			$criteria = new TCriteria();
			$criteria->add(new TFilter('cod','=',$codUsuario));
			
			return $this->selecionar($criteria);
		}
		
		public function pesquisar($campo = '',$valor = '',$ordenacao = '')
		{
			$criteria = new TCriteria;
			
			if((!empty($campo)) and (!empty($valor)))
			{	
				$criteria->add(new TFilter($campo,'LIKE','%'.$valor.'%'));
			}
		
			if(!empty($ordenacao))
			{
				$criteria->setProperty('order',$ordenacao);
			}
			
			return $this->selecionarColecao($criteria);
		}
		
		public function alterarSenha($senha,$login,$duracao,Lib $objLib,$tipo,$senhaRepetida = '')
		{
			/*
				TIPO: 1 - QUANDO O MÉTODO É CHAMADO UTILIZADO PARA FAZER A MUDANÇA DA SENHA PELO PRÓPRIO USUÁRIO
				0 - QUANDO O MÉTODO É CHAMADO PARA FAZER A MUDANÇA DA SENHA NO CADASTRO DO USUÁRIO
			*/
			
			$sql = "ALTER USER ".$login." ENCRYPTED PASSWORD '".$senha."'";
			
			if($tipo == '1')
			{
				if((!empty($senha)) and (!empty($senhaRepetida)) and ($senha == $senhaRepetida))
				{
					//ALTERANDO A VALIDADE DA SENHA
					if($duracao != '0')
					{
						$validade = $lib->somarMesDataAtual($duracao);
						
						$this->alterarValidadeSenha($login,$duracao,$validade);
						
						//SALVANDO A NOVA VALIDADE
						$dados['validadesenha'] = $lib->converterDataToUs($validade);
						$this->atualizarUsuariosSemValidacao($dados,$codUsuario);
					}
					
					return $this->executar($sql);
				} else
				{
					return false;
				}
			} else
			{
				
				return $this->executar($sql);
			}
		}
		
		public function alterarValidadeSenha($login,$duracao,$validade = '')
		{
			$sql = "ALTER USER ".$login." VALID UNTIL";
			
			if($duracao == '0')
			{
				$sql .= " 'infinity'";
			} else
			{
				$sql .= " '".$validade." 00:00:00'";
			}
		
			return $this->executar($sql);
		}
		
		public function concederPrivilegio($perfil,$login,$tipo = '1')
		{
			if($tipo == '1')
			{
				$sql = "GRANT ".$perfil." TO ".$login;
			} else
			{
				$sql = "REVOKE ".$perfil." FROM ".$login;
			}
			
			return $this->executar($sql);
		}
		
		public function concederLogin($login,$tipo = '1')
		{
			$sql = "ALTER USER ".$login;
			
			if($tipo == '1')
			{
				$sql .= " LOGIN";
			} else
			{
				$sql .= " NOLOGIN";
			}
			
			return $this->executar($sql);
		}
		
		public function concederSuperUsuario($login,$tipo = '1')
		{
			$sql = "ALTER USER ".$login;
			
			if($tipo == '1')
			{
				$sql .= " SUPERUSER";
			} else
			{
				$sql .= " NOSUPERUSER";
			}
			
			return $this->executar($sql);
		}
		
		public function getUsuarioByLogin($login)
		{
			$criteria = new TCriteria();
			$criteria->add(new TFilter('login','=',$login));
			
			return $this->selecionar($criteria);
		}
		
		public function iniciarSessao($login,sistFuncionalidadesPerfilRecord $objFuncPerfil)
		{
			$rs = $this->getUsuarioByLogin($login);
			
			if($rs)
			{
				$_SESSION["CODUSUARIO"] = $rs['COD']['0'];
				$_SESSION["PERFIL"] = $rs['PERFIL']['0'];	
				
				$rsFunc = $objFuncPerfil->listarPermissoes($rs['PERFIL']['0']);
				
				return true;
			} else
			{
				return false;
			}
		}

                /*
                 * TODO Não seria melhor utilizar como na função logoff() utilizando o session_destroy()?
                 */
		public function encerrarSessao()
		{
			unset($_SESSION["CODUSUARIO"]);
			unset($_SESSION["PERFIL"]);
			unset($_SESSION["FUNC"]);
		}
		
		public function autenticarUsuario($login,$senha,sistFuncionalidadesPerfilRecord $objFuncPerfil)
		{
			if($this->validarConexao($login,$senha))
			{
				//SENHA
				define("DBPASS",$senha);
				
				//USUÁRIO
				define("DBUSER",$login);
				
				return $this->iniciarSessao($login,$objFuncPerfil);
			} else
			{
				$this->encerrarSessao();
				
				return false;
			}
		}

		protected function validarSessao()
		{
				if (isset($_SESSION['CODUSUARIO']))
				{
						return true;
				}
				else
				{
						return false;
				}
		}

		protected function validaLDAP($login, $senha, $servidor = LDAPSERVER, $dominio = LDAPDOMAIN)
		{
				$user = $dominio.'\\'.$login;

				if (!($conexao = @ldap_connect($servidor)))
				{
						return false;
				}
				if (!($bind = @ldap_bind($conexao, $user, $senha)))
				{
						return false;
				}
				else
				{
						return true;
				}
		}

		protected function setLoginCookie()
		{
				setcookie('login', $this->login);
		}

		protected function setTimeAway($segundos = COOKIETIMEAWAY)
		{
				setcookie('isLogado', '1', time() + $segundos);
		}

		protected function isAway()
		{
				if(empty($_COOKIE['isLogado']))
				{
						return true;
				}
				else
				{
						return false;
				}
		}

		function delCookieAway()
		{
				setcookie('isLogado', '');
		}

		function logoff()
		{
				$this->delCookieAway();
				session_destroy();
				header('location: index.php?tipoMsg=1&msg=4');
		}

		function logoffSessao()
		{
				$this->delCookieAway();
				session_destroy();
				header('location: index.php?tipoMsg=1&msg=41');
		}
		
		public function getUsuarioByNome($nome,$ordCampo = '',$ordType = '')
		{
			$criteria = new TCriteria();
			$criteria->add(new TFilter('nome','LIKE',$nome.'%'));
			
			if(!empty($ordCampo))
			{
				$criteria->setProperty('order',$ordCampo);
			}
			
			if(!empty($ordType))
			{
				$criteria->setProperty('type',$ordType);
			}
			
			return $this->selecionarColecao($criteria);
		}
	}
?>