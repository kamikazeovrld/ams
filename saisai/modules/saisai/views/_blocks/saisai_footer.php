	<script type="text/javascript">
		<?=$this->load->module_view(SAISAI_FOLDER, '_blocks/saisai_header_jqx', array(), TRUE)?>
	</script>
	<?=js('jqx/jqx', 'saisai')?>
	<?php $saisai_js = $this->saisai->config('saisai_javascript'); ?>
	<?php foreach($saisai_js as $m => $j) : echo js(array($m => $j))."\n\t"; endforeach; ?>

	<?php foreach($js as $m => $j) : echo js(array($m => $j))."\n\t"; endforeach; ?>

	<?php if (!empty($this->js_controller)) : ?> 
	<script type="text/javascript">
		<?php if ($this->js_controller != 'saisai.controller.BaseSaisaiController') : ?>
		jqx.addPreload('saisai.controller.BaseSaisaiController');
		<?php endif; ?>
		jqx.init('<?=$this->js_controller?>', <?=json_encode($this->js_controller_params)?>, '<?=$this->js_controller_path?>');
	</script>
	<?php endif; ?>

