<?php
    /*
     * Autor: Marcos Rosa
     * Data: 29/07/2011
     * Descrição: Classe que faz a ligaçào entre a tabela usuário e as perguntas secretas 
     */
	 
	 
class RespostaPerguntasRecord extends ManipulaBanco{
	
	
	function __construct(){
	}

	//Recebe fk_cd_usuario, fk_cd_perguntas e a resposta da pergunta
	public function cadastrarResposta($dados){
                       
		 if ($this->salvar($dados)){ 
	
			return $this->ultimoId('opcoesperguntas_cd_pergunta_seq', 'pgsql'); //Último id da sequencia
		 }
		 
		 else {
			 echo "Erro ao cadastrar nova resposta a pergunta secreta!";
			 exit;
		 }
	}
}

?>
             