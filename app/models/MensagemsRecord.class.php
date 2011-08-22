<?php
    /*
     * Autor: Marcos Rosa
     * Data: 12/08/2011
     * Descrição: Classe genérica para manipulação de registros das mensagens
     */
	 
	 
class MensagemsRecord extends ManipulaBanco{
	
	
	function __construct(){
	}

	public function cadastrarEndereco($dados){
                       
		 if ($this->salvar($dados)){ 
	
			return TRUE;
		 }
		 
		 else {
			 echo "Erro ao cadastrar mensagem!";
			 exit;
		 }
	}
	
	public function excluirMensagem($cd){
		
			$criteria = new TCriteria();			
			
			$criteria->add(new TFilter('cd_mensagem','=',$cd));

			return $this->deletar($criteria);
	}
	
	public function atualizarMensagem($dados, $cd_mensagem){
		
			return $this->atualizar($dados,$cd_mensagem);
	}
		
	
	public function listaMensagens($destinatario){
		
		$sql = "SELECT * FROM mensagem WHERE destinatario = '$destinatario' ORDER BY hora DESC;";
		$result = $this->executarPesquisa($sql);
		
		return $result;
	}
	
	public function getMensagem($cd_mensagem){
		
		$sql = "SELECT * FROM mensagem WHERE cd_mensagem = '$cd_mensagem';";
		$result = $this->executarPesquisa($sql);
		
		return $result;
	}
	
}
?>