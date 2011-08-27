<?php
    /**
     * Classe que faz a ligaçào a tabela habilidade e os usuários
     * 
     * @package app
     * @subpackage models
     * @author Marcos Rosa
     * @since 29/07/2011
     * 
     */
	 
	 
class UsuarioHabilidadesRecord extends ManipulaBanco{
	
	
	function __construct(){
	}

	/**
         * Metodo que inseri uma habilidade ao usuario
         *
         * @param array $dados 
         * @return boolean
         */ 
	public function cadastrarHabilidade($dados){
                       
            return $this->salvar($dados);
	}
}

?>
             