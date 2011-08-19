<?php
    /*
     * Autor: Marcos Rosa
     * Data: 20/07/2011
     * Descrição: Classe genérica para manipulação de registros dos endereços
     */
	 
	 
class EnderecosRecord extends ManipulaBanco{
	
	
	function __construct(){
	}

	public function cadastrarEndereco($endereco){
                       
		 if ($this->salvar($endereco)){ 
	
			return $this->ultimoId('endereco_cd_endereco_seq', 'pgsql'); //Último id da sequencia
		 }
		 
		 else {
			 echo "Erro ao cadastrar endereço!";
			 exit;
		 }
	}
	
	public function atualizarEndereco($dados, $cd_endereco){
		
			return $this->atualizar($dados,$cd_endereco);
	}
	
	public function retornaDados($cd_endereco){
		
		$sql = "SELECT * FROM endereco WHERE cd_endereco = '$cd_endereco'";
		$result = $this->executarPesquisa($sql);
		return $result;
	
	}
}
?>