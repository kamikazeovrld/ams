
var jqx_config = {};
jqx_config.basePath =  "<?=(trim(site_url(), '/').'/');?>";
jqx_config.jsPath = "<?=js_path('', 'saisai')?>";
jqx_config.imgPath = "<?=img_path('', 'saisai')?>";

jqx_config.uriPath = "<?=uri_path(FALSE)?>";
jqx_config.assetsImgPath = "<?=img_path('')?>";
jqx_config.assetsPath = "<?=assets_path('')?>";
jqx_config.assetsCssPath = "<?=css_path('')?>";
jqx_config.controllerName = 'saisai';
jqx_config.jqxPath = jqx_config.jsPath + "jqx/";
jqx_config.controllerPath = jqx_config.jsPath + "saisai/controller/";
jqx_config.pluginPath = jqx_config.jsPath + 'jquery/plugins/';
jqx_config.saisaiPath = '<?=site_url($this->saisai->config('saisai_path'))?>';
jqx_config.cookieDefaultPath = '<?=$this->saisai->config('saisai_cookie_path')?>';
<?php if (!empty($keyboard_shortcuts)){ ?>jqx_config.keyboardShortcuts = <?=json_encode($keyboard_shortcuts)?>;<?php } ?> 
jqx_config.warnIfModified = <?=(int)$this->saisai->config('warn_if_modified')?>;
jqx_config.cacheString = new Date('<?=date('F d, Y H:i:s', strtotime($this->config->item('last_updated'))) ?>').getTime().toString();
jqx_config.assetsAccept = '<?php $editable_asset_types = $this->saisai->config('editable_asset_filetypes'); echo (!empty($editable_asset_types['assets']) ? $editable_asset_types['assets'] : 'jpg|jpeg|jpe|gif|png'); ?>';
jqx_config.lang = '<?=$this->saisai->auth->user_lang()?>';
<?php if (!empty($js_localized)) :?>
jqx_config.localized = <?=json_lang($js_localized)?>;
var __SAISAI_LOCALIZED__ = <?=json_lang($js_localized)?>;
<?php else:  ?>
jqx_config.localized = <?=json_lang('saisai/saisai_js', 'english')?>;
var __SAISAI_LOCALIZED__ = <?=json_lang('saisai/saisai_js', 'english')?>;
<?php endif; ?>
jqx_config.editor = '<?=$this->saisai->config('text_editor')?>';
jqx_config.ckeditorConfig = <?=is_array($this->saisai->config('ck_editor_settings')) ? json_encode($this->saisai->config('ck_editor_settings')) : $this->saisai->config('ck_editor_settings')?>;
jqx_config.uiCookie = 'saisai_ui_<?=str_replace('saisai_', '', $this->saisai->auth->get_saisai_trigger_cookie_name())?>';
var __SAISAI_PATH__ = '<?=site_url($this->saisai->config('saisai_path'))?>'; // for preview in markitup settings
var CKEDITOR_BASEPATH = '<?=js_path('', 'saisai')?>editors/ckeditor/';
