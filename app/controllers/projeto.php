<?php
/** Controlador - Projeto
@Author: Anderson Rodrigues*/
	include_once '../../conf/lock.php';
	
	$lib = new Lib(); 
	$projeto = new ProjetosRecord();
	
	$acao = $_GET['acao'];

	$str_erro = '';
	switch($acao)
	{
		case "add":
		{
			/*
                         * FAZ AS VALIDAÇÕES
                         */
                        session_unregister('nome_projeto');
                        $dados['nome_projeto'] = $lib->formatarString($_POST['nome_projeto']);
                        if (empty($dados['nome_projeto']) || (strlen($dados['nome_projeto'])<3))
                        {
                            $str_erro .= '<ul>Verifique o nome do projeto favor digite um nome válido com no mínimo 3 caracteres </ul>';
                        }
                        $_SESSION['nome_projeto'] = $dados['nome_projeto'];
			
                        session_unregister('ds_projeto');
                        $dados['ds_projeto'] = $lib->formatarString($_POST['ds_projeto']);
                        if (empty($dados['ds_projeto']) || (strlen($dados['ds_projeto'])<3))
                        {
                            $str_erro .= '<h2>Verifique a descrição do projeto favor digite um nome válido com no mínimo 3 caracteres </h2>';
                        }
                        $_SESSION['ds_projeto'] = $dados['ds_projeto'];


			$dados['dt_inicio_proj'] = date('Y-m-d H:i:s');
                        session_unregister('dt_previsao_termino_proj');
			if ($lib->isDate($_POST['dt_previsao_termino_proj']))
                        {
                            if ($lib->subtrairDatas( date_create_from_format('d/m/Y', $_POST['dt_previsao_termino_proj']), date('d/m/Y'))<0)
                            {
                                $str_erro .= '<h2>A data de previsão de termino não pode ser inferior a data atual.</h2>';
                            }
                            $dados['dt_previsao_termino_proj'] = $lib->converterDataToUs($_POST['dt_previsao_termino_proj']);
                        }
                        else
                        {
                             $str_erro .= '<h2>A data de previsão de termino é inválida.</h2>';
                        }
                        $dados['fk_cd_status'] = 1;//seto o projeto como criado.
                        $_SESSION['dt_previsao_termino_proj'] = $_POST['dt_previsao_termino_proj'];
			/*
                         * se existem erros aviso ao usuario e solicito correção
                         */
                        $dados['gerente_geral'] = $_SESSION['login'];
                        session_unregister('str_erro');
                        if (!empty($str_erro))
                        {
                            $_SESSION['str_erro'] = $str_erro;
                            header('Location: ../views/projetoAdd.php');
                        }
                        else
                        {
			if( $projeto->cadastrarProjetos($dados) )
                            echo ("Projeto criado com sucesoo.<br>\n");
                        else
                            echo ("ERRO! projeto não foi criado.<br>\n");
			break;
                        }
		}
		
		case "edit":
		{
                        /*
                         * VERIFICAR SE O USUARIO É GERENTE GERAL
                         * aki eu tenho que pegar o codigo via sessão
                         */
                        $dados['cd_projeto'] = $lib->antiInjection( $_POST['cd_projeto']);

                         session_unregister('nome_projeto');
                        $dados['nome_projeto'] = $lib->formatarString($_POST['nome_projeto']);
                        if (empty($dados['nome_projeto']) || (strlen($dados['nome_projeto'])<3))
                        {
                            $str_erro .= '<ul>Verifique o nome do projeto favor digite um nome válido com no mínimo 3 caracteres </ul>';
                        }
                        $_SESSION['nome_projeto'] = $dados['nome_projeto'];

                        session_unregister('ds_projeto');
                        $dados['ds_projeto'] = $lib->formatarString($_POST['ds_projeto']);
                        if (empty($dados['ds_projeto']) || (strlen($dados['ds_projeto'])<3))
                        {
                            $str_erro .= '<h2>Verifique a descrição do projeto favor digite um nome válido com no mínimo 3 caracteres </h2>';
                        }
                        $_SESSION['ds_projeto'] = $dados['ds_projeto'];


			$dados['dt_inicio_proj'] = date('Y-m-d H:i:s');
                        session_unregister('dt_previsao_termino_proj');
			if ($lib->isDate($_POST['dt_previsao_termino_proj']))
                        {
                            if ($lib->subtrairDatas( date_create_from_format('d/m/Y', $_POST['dt_previsao_termino_proj']), date('d/m/Y'))<0)
                            {
                                $str_erro .= '<h2>A data de previsão de termino não pode ser inferior a data atual.</h2>';
                            }
                            $dados['dt_previsao_termino_proj'] = $lib->converterDataToUs($_POST['dt_previsao_termino_proj']);
                        }
                        else
                        {
                             $str_erro .= '<h2>A data de previsão de termino é inválida.</h2>';
                        }
                        $dados['fk_cd_status'] = 1;//seto o projeto como criado.
                        $_SESSION['dt_previsao_termino_proj'] = $_POST['dt_previsao_termino_proj'];
			/*
                         * se existem erros aviso ao usuario e solicito correção
                         */
                        session_unregister('str_erro');
                        if (!empty($str_erro))
                        {
                            $_SESSION['str_erro'] = $str_erro;
                            header('Location: ../views/projetoEdit.php');
                        }
                        else
                        {
			if ($projeto->atualizarProjetos($dados, $dados['cd_projeto']))
                                echo ("PROJETO ATUALIZADO COM SUCESSO.<BR>\n");
                        else
                                echo ("ERRO NÃO FOI POSSIVEL ATUALIZAR O PROJETO.<BR>\n");
			
			break;
                        }
		}
		
		case "delete":
		{
                        //verificar se o usuario é gerente geral para deletar projeto
                        $dados['cd_projeto'] = $lib->formatarString($_POST['cd_projeto']);
			break;
		}

                case "editCrono":
                {
                    $acao2 = $_POST['acao2'];
                    $dados['cd_projeto'] = $lib->formatarString($_POST['cd_projeto']);
                    $status =  new StatusProjeto();
                    switch ($acao2)
                    {
                        case "concluir":
                        {
                            //conclusao do projeto
                            $dados['dt_termino_proj'] = date('Y-m-d H:i:s');
                            $dados['fk_cd_status'] = $status->getCodByName('concluido');
                            break;
                        }
                        case "inativar":
                        {
                            //inativação
                            $dados['fk_cd_status'] = $status->getCodByName('inativo');
                            break;
                        }
                        case "alterar":
                        {
                            //alteracao de cronograma
                            /*
                             * @TODO tenho de expandir a tarefa de gerencia do projeto
                             */
                            $dados['dt_previsao_termino_proj'] = $lib->converterDataToUs($_POST['dt_previsao_termino_proj']);
                            $dados['fk_cd_status'] = $status->getCodByName('atrasado');
                            break;
                        }
                    }
                    //verificar se o usuario é gerente geral para deletar projeto
                    if ($projeto->atualizarProjetos($dados, $dados['cd_projeto']))
                                echo ("CRONOGRAMA DO PROJETO ATUALIZADO COM SUCESSO.<BR>\n");
                        else
                                echo ("ERRO NÃO FOI POSSIVEL ATUALIZAR CRONOGRAMA O PROJETO.<BR>\n");
			break;
                }
	}
?>