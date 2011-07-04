<?php	
	include_once '../../conf/lock.php';
	
	$validade = $_GET['val'];
	 
	if($validade != '0')
	{
?>
		<label>Validade:<input type="text" name="validade" id="validade" size="10" maxlength="10" value="<?php echo $validade;?>"></label>
<?php
	} else
	{
?>
		<label>Validade:<input type="text" name="validade" id="validade" size="10" maxlength="10"></label>
<?php
	}
?>