<?php
    /*
     * Autor: Marcos Rosa
     * Data: 29/07/2011
     * Descrição: Classe que faz a ligaçào a tabela habilidade e os usuários
     */
	 
	 
class UsuarioHabilidadesRecord extends ManipulaBanco{
	
	
	function __construct(){
	}

	//Recebe fk_cd_usuario, fk_cd_habilidade 	 
	public function cadastrarHabilidade($dados){
                       
		 if ($this->salvar($dados)){}
		 
		 else {
			 echo "Erro ao cadastrar nova habilidade!";
			 exit;
		 }
	}
}

?>
             