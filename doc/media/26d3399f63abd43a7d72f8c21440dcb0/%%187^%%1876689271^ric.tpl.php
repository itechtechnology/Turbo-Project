<?php /* Smarty version 2.6.0, created on 2011-08-26 03:05:37
         compiled from ric.tpl */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlentities', 'ric.tpl', 4, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<h1 align="center"><?php echo $this->_tpl_vars['name']; ?>
</h1>
<pre>
<?php echo ((is_array($_tmp=$this->_tpl_vars['contents'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp) : smarty_modifier_htmlentities($_tmp)); ?>

</pre>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>