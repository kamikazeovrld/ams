<div id="saisai_main_content_inner">
	
	<div class="boxbuttons">

	<ul>
	<?php foreach($modules as $key => $module) : ?>
		<?php if ($this->saisai->auth->has_permission($key)) : ?>
		<li><a href="<?=$module->saisai_url()?>" class="ico <?=$module->icon()?>"><?=$module->friendly_name()?></a></li>
		<?php endif; ?>
	<?php endforeach; ?>
	</ul>
	</div>
	
	<div class="clear"></div>
	
	
</div>
