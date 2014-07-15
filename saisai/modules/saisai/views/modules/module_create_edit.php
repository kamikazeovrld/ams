<!-- RELATED ITEMS -->
<?php $this->load->module_view(SAISAI_FOLDER, '_blocks/related_items'); ?>

<!-- NOTIFICATION EXTRA -->
<?php $this->load->module_view(SAISAI_FOLDER, '_blocks/notification_extra'); ?>

<!-- WARNING WINDOW -->
<?php $this->load->module_view(SAISAI_FOLDER, '_blocks/warning_window'); ?>


<div id="saisai_main_content_inner">

	<?php if (!empty($instructions)) : ?>
	<p class="instructions"><?=$instructions?></p>
	<?php endif; ?>

	<?=$form?>

</div>