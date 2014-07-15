<script type="text/javascript">
//<![CDATA[
	var CKEDITOR_BASEPATH = '<?=js_path('', 'saisai')?>editors/ckeditor/';
	//var __SAISAI_INLINE_EDITING = true;
	var __SAISAI_INIT_PARAMS__ = <?=json_encode($init_params)?>;
	var __SAISAI_LOCALIZED__ = <?=$js_localized?>;
	var __SAISAI_PATH__ = '<?=site_url($this->config->item('saisai_path', 'saisai'))?>'; // for preview in markitup settings
	var __SAISAI_LINKED_FIELDS = null;

	// to prevent some issues with loading jquery twice on the page
	if (typeof jQuery == 'undefined'){
		document.write('<script type="text/javascript" charset="utf-8" src="<?=js_path('jquery/jquery', 'saisai')?>"><\/script>');
	}

	// must be less then version 1.9 or we will load campatability helper
	var __jq_version__ = jQuery.fn.jquery.split('.');
	if (parseInt(__jq_version__[0]) > 1 || (parseInt(__jq_version__[0]) == 1 && parseInt(__jq_version__[1]) >= 9)){
		jQuery.migrateMute = true;
		document.write('<script type="text/javascript" charset="utf-8" src="<?=js_path('jquery/plugins/jquery-migrate-1.1.1.js', 'saisai')?>"><\/script>');
	}

//]]>
</script>
<?=js('saisai/saisai_inline.min.js', 'saisai', array('ignore_if_loaded' => TRUE, 'output' => $this->saisai->config('saisai_assets_output')))?>

<div class="__saisai__" id="__saisai_edit_bar__">
	<?=$this->form->open(array('action' => saisai_url('pages/ajax_page_edit/'), 'method' => 'post', 'id' => '__saisai_edit_bar_form__'))?>
	<div class="buttonbar buttonbar_notop">

		<ul>
			<?php if (!isset($page['id']) AND $is_saisaiified) : ?>
				
				
				<li class="<?=(isset($page['published']) && !is_true_val($page['published']))? 'exposed' : 'start round exposed'; ?>"><a href="#" id="__saisai_page_toolbar_toggle__" class="ico ico_saisai" title="<?=lang('inline_edit_toggle_toolbar')?>"></a></li>
				<?php if ($can_edit_pages) : ?>
				<li class="<?php if (!empty($_COOKIE['saisai_show_editable_areas']) && $_COOKIE['saisai_show_editable_areas'] == 1) : ?>active<?php endif; ?>"><a href="#" id="__saisai_page_edit_toggle__" class="ico ico_edit" title="<?=lang('inline_edit_toggle_editable')?>"></a></li>
				<?php endif; ?>

				<?php if (count($tools) > 0) : ?><li> &nbsp;<?=$this->form->select('tools', $tools, '', 'id="__saisai_page_tools__"', lang('inline_edit_tools'))?> </li><?php endif; ?>
				<li class="txt"><a href="<?=saisai_url('recent')?>"><?=lang('inline_edit_back_to_admin')?></a></li>
				<li class="txt"><a href="<?=saisai_url('logout/'.$last_page)?>" class="" title="<?=lang('inline_edit_logout_title')?>"><?=lang('inline_edit_logout')?></a></li>
			<?php else: ?>
		
				<?php if (isset($page['published']) && !is_true_val($page['published'])) : ?>
						<li class="start unpublished round exposed"><?=lang('inline_edit_page_not_published')?></li>
				<?php endif; ?>
				
				<li class="<?=(isset($page['published']) && !is_true_val($page['published']))? 'exposed' : 'start round exposed'; ?>"><a href="#" id="__saisai_page_toolbar_toggle__" class="ico ico_saisai" title="<?=lang('inline_edit_toggle_toolbar')?>"></a></li>
				

				<?php if ($is_saisaiified AND $can_edit_pages) : ?>


				<li<?php if (!empty($_COOKIE['saisai_show_editable_areas']) && $_COOKIE['saisai_show_editable_areas'] == 1) : ?> class="active"<?php endif; ?>><a href="#" id="__saisai_page_edit_toggle__" class="ico ico_edit" title="<?=lang('inline_edit_toggle_editable')?>"></a></li>
			
				<?php if (isset($page['published'])) : ?>
					<?php $publish = (!is_true_val($page['published'])) ? 'unpublish' : 'publish';?>
					<li<?php if (is_true_val($page['published'])) : ?> class="active"<?php endif; ?>><a href="#" class="ico ico_<?=$publish?>" id="__saisai_page_publish_toggle__" title="<?=lang('inline_edit_toggle_publish')?>"></a></li>
					<?=$this->form->hidden('published', $page['published'], 'id="__saisai_page_published__"')?>
				<?php endif; ?>

				<?php if (isset($page['cache'])) : ?>
					<li<?php if (is_true_val($page['cache'])) : ?> class="active"<?php endif; ?>><a href="#" class="ico ico_cache" id="__saisai_page_cache_toggle__" title="<?=lang('inline_edit_toggle_cache')?>"></a></li>
					<?=$this->form->hidden('cache', $page['cache'], 'id="__saisai_page_cached__"')?>
				<?php endif; ?>
			
				<?php if ($this->saisai->language->has_multiple()) : ?>
					<li> &nbsp;<?=$this->form->select($this->saisai->language->query_str_param, $this->saisai->language->options(), $language, 'id="__saisai_language__"')?>
						<?=$this->form->hidden('language_mode', $language_mode, 'id="__saisai_language_mode__"')?>
						<?=$this->form->hidden('language_default', $language_default, 'id="__saisai_language_default__"')?>
					</li>
				<?php endif; ?>
				
				<?php endif; ?>

				<?php if (count($tools) > 0) : ?><li> &nbsp;<?=$this->form->select('tools', $tools, '', 'id="__saisai_page_tools__"', lang('inline_edit_tools'))?> </li><?php endif; ?>
				<?php if (count($others) > 0) : ?><li> &nbsp;<?=$this->form->select('others', $others, '', 'id="__saisai_page_others__"', lang('inline_edit_other_pages'))?> </li><?php endif; ?>
				<?php if (count($layouts) > 1 AND $can_edit_pages) : ?><li><label for="layout"><?=lang('inline_edit_layout')?></label> <?=$this->form->select('layout', $layouts, $page['layout'], 'id="__saisai_page_layout__"')?></li><?php endif; ?>

				
				<?php if (!empty($page['id'])) : ?>
				<li class="txt"><a href="<?=saisai_url('pages/edit/'.$page['id'].'?lang='.$language)?>" title="<?=lang('inline_edit_back_to_admin')?>"><?=lang('inline_edit_back_to_admin')?></a></li>
				<?php endif; ?>
				
				<?php if ($is_saisaiified) : ?>
				<li class="txt"><a href="<?=saisai_url('logout/'.$last_page)?>" title="<?=lang('inline_edit_logout_title')?>"><?=lang('inline_edit_logout')?></a></li>
				<?php else: 
				$uri = uri_string();
				if ($uri == '') $uri = 'home';
				?>
				<li class="txt"><a href="<?=saisai_url('login/'.uri_safe_encode($uri))?>" title="<?=lang('inline_edit_login_title')?>"><?=lang('inline_edit_login')?></a></li>
				<?php endif; ?>
				


			<?php endif; ?>
		</ul>
		<div class="clear"></div>
	</div>
	<?php if (isset($page['id'])) : ?>
	<?=$this->form->hidden('id', $page['id'], 'id=""')?>
	<?=$this->form->hidden('location', $page['location'], 'id=""')?>
	<?php endif; ?>
	<?=$this->form->close()?>
	
</div>