<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
 	<title><?=$page_title?></title>
	<?=css('saisai.min', SAISAI_FOLDER)?>
	<?php if (!empty($css)) : ?>
	<?=$css?>
	<?php endif; ?>
	<script type="text/javascript">
	<?=$this->load->module_view('saisai', '_blocks/saisai_header_jqx', array(), TRUE)?>
	</script>
	<?=js('jquery/jquery', SAISAI_FOLDER)?>
	<?=js('jqx/jqx', SAISAI_FOLDER)?>
	<script type="text/javascript">
		jqx.addPreload('saisai.controller.BaseSaisaiController');
		jqx.init('saisai.controller.LoginController', {});
	</script>

</head>
<body>
<div id="login">
		
		<div class="login_logo">
			<span class="hidden">SAISAI CMS</span>
		</div>

		<div id="login_notification" class="notification">
			<?=$notifications?>
		</div>
		<?php if (!empty($instructions)) : ?>
		<p><?=$instructions?></p>
		<?php endif; ?>
		<?=$form?>
		<?php if ($display_forgotten_pwd) : ?>
			<a href="<?=saisai_url('login/pwd_reset')?>" id="forgotten_pwd"><?=lang('login_forgot_pwd')?></a>
		<?php endif; ?>
	</div>
</div>
</body>
</html>