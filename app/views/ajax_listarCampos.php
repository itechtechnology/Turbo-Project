<?php
	include_once '../../conf/lock.php';
	
	$DB = new DBManager();
	
	$tabela = $_GET['filtro'];
	 
	$tabela = explode(".",$tabela);
	
	$colunas = $DB->listarCamposByTabela($tabela["1"]);
	
	$totalColuna = count($colunas['CAMPO']);
?>

	<label>
		SELECIONAR:
        <select onDblClick="move(this.form.selecorigem,this.form.selecdestino)" multiple="MULTIPLE" size="10" name="selecorigem[]" id="selecorigem" style="width:220">
<?php
			for($x=1;$x<=$totalColuna;$x++)
			{
?>
				<option value="<?php echo $colunas['CAMPO'][$x];?>"><?php echo strtoupper($colunas['CAMPO'][$x]);?></option>
<?php
			}
?>
		</select>
		
		<input type="button" onClick="move(this.form.selecdestino,this.form.selecorigem)" value="<">
		<input type="button" onClick="selecionatudo('selecdestino'); move(this.form.selecdestino,this.form.selecorigem)" value="<<">
		<input type="button" onClick="selecionatudo('selecorigem'); move(this.form.selecorigem,this.form.selecdestino)" value=">>">
		<input type="button" onClick="move(this.form.selecorigem,this.form.selecdestino)" value=">">

        <select onDblClick="move(this.form.selecdestino,this.form.selecorigem)" multiple="MULTIPLE" size="10" name="selecdestino[]" id="selecdestino" style="width:220"></select>
	</label><br />
	
	<label>
		ATUALIZAR:
        <select onDblClick="move(this.form.atuaorigem,this.form.atuadestino)" multiple="MULTIPLE" size="10" name="atuaorigem[]" id="atuaorigem" style="width:220">
<?php
			for($x=1;$x<=$totalColuna;$x++)
			{
?>
				<option value="<?php echo $colunas['CAMPO'][$x];?>"><?php echo strtoupper($colunas['CAMPO'][$x]);?></option>
<?php
			}
?>
		</select>
		
		<input type="button" onClick="move(this.form.atuadestino,this.form.atuaorigem)" value="<">
		<input type="button" onClick="selecionatudo('atuadestino'); move(this.form.atuadestino,this.form.atuaorigem)" value="<<">
		<input type="button" onClick="selecionatudo('atuaorigem'); move(this.form.atuaorigem,this.form.atuadestino)" value=">>">
		<input type="button" onClick="move(this.form.atuaorigem,this.form.atuadestino)" value=">">

        <select onDblClick="move(this.form.atuadestino,this.form.atuaorigem)" multiple="MULTIPLE" size="10" name="atuadestino[]" id="atuadestino" style="width:220"></select>
	</label><br />
	<label>
		INSERIR:
        <select onDblClick="move(this.form.inseorigem,this.form.insedestino)" multiple="MULTIPLE" size="10" name="inseorigem[]" id="inseorigem" style="width:220">
<?php
			for($x=1;$x<=$totalColuna;$x++)
			{
?>
				<option value="<?php echo $colunas['CAMPO'][$x];?>"><?php echo strtoupper($colunas['CAMPO'][$x]);?></option>
<?php
			}
?>
		</select>
		
		<input type="button" onClick="move(this.form.insedestino,this.form.inseorigem)" value="<">
		<input type="button" onClick="selecionatudo('insedestino'); move(this.form.insedestino,this.form.inseorigem)" value="<<">
		<input type="button" onClick="selecionatudo('inseorigem'); move(this.form.inseorigem,this.form.insedestino)" value=">>">
		<input type="button" onClick="move(this.form.inseorigem,this.form.insedestino)" value=">">

        <select onDblClick="move(this.form.insedestino,this.form.inseorigem)" multiple="MULTIPLE" size="10" name="insedestino[]" id="insedestino" style="width:220"></select>
	</label><br />
	<label>DELETAR<input type="checkbox" name="deletar" id="deletar" value="d"></label><br />