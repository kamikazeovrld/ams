<?php
require_once(SAISAI_PATH.'/libraries/Saisai_base_controller.php');

class Build extends Saisai_base_controller {

	function __construct()
	{
		// don't validate yet... we check that you are a super admin later
		parent::__construct(FALSE);

		if (is_environment('production'))
		{
			exit('Cannot execute in production environment');
		}
	}
	
	function _remap($module, $segs = NULL)
	{
		$remote_ips = $this->saisai->config('webhook_remote_ip');
		$is_web_hook = ($this->saisai->auth->check_valid_ip($remote_ips));

		// check if it is CLI or a web hook otherwise we need to validate
		$validate = (php_sapi_name() == 'cli' OR defined('STDIN') OR $is_web_hook) ? FALSE : TRUE;

		// Only super admins can execute builds for now
		if ($validate AND !$this->saisai->auth->is_super_admin())
		{
			show_error(lang('error_no_access'));
		}

		// call before build hook
		$params = array('module' => $module);
		$GLOBALS['EXT']->_call_hook('before_build', $params);


		// get the type of build which can either be CSS or JS
		$type = array_shift($segs);

		$valid_types = array('css', 'js');
		if (!empty($type) AND in_array($type, $valid_types))
		{	
			$this->load->helper('file');

			// get the folder name if it exists
			$segs_str = implode('/', $segs);

			// explode on colon to separate the folder name from the file name
			$seg_parts = explode(':', $segs_str);

			// set the folder name to lookin
			$folder = $seg_parts[0];

			// set the file name if one exists
			$filename = (!empty($seg_parts[1])) ? $seg_parts[1] : 'main.min';

			// get list of files
			$files_path = assets_server_path($folder, $type);
			$_files = get_filenames($files_path, TRUE);
			$files = array();

			foreach($_files as $file)
			{
				// trim to normalize path
				$replace = trim(assets_server_path('', $type), '/');
				$files[] = str_replace($replace, '', trim($file, '/'));
			}


			$output_params['type'] = $type;
			$output_params['whitespace'] = TRUE;
			$output_params['destination'] = assets_server_path($filename.'.'.$type, $type, $module);
			$output = $this->asset->optimize($files, $output_params);
			echo lang('module_build_asset', strtoupper($type), $output_params['destination']);
		}
		else if ($module != 'index' AND $this->saisai->modules->exists($module) AND $this->saisai->modules->is_advanced($this->saisai->$module))
		{
			$results = $this->saisai->$module->build();

			if ($results === FALSE)
			{
				echo lang('error_no_build');
			}
		}
		else
		{
			// run default SAISAI optimizations if no module is passed
			$this->optimize_js();
			$this->optimize_css();
		}

		// call after build hook
		$GLOBALS['EXT']->_call_hook('after_build', $params);

	}

	
	function optimize_js()
	{
		$js = array(
			'jquery/plugins/jquery-ui-1.8.17.custom.min',
			'jquery/plugins/jquery.easing',
			'jquery/plugins/jquery.bgiframe',
			'jquery/plugins/jquery.tooltip',
			'jquery/plugins/jquery.scrollTo-min',
			'jquery/plugins/jqModal',
			'jquery/plugins/jquery.checksave',
			'jquery/plugins/jquery.form',
			'jquery/plugins/jquery.treeview',
			'jquery/plugins/jquery.serialize',
			'jquery/plugins/jquery.cookie',
			'jquery/plugins/jquery.supercookie',
			'jquery/plugins/jquery.hotkeys',
			'jquery/plugins/jquery.cookie',
			'jquery/plugins/jquery.simpletab.js',
			'jquery/plugins/jquery.tablednd.js',
			'jquery/plugins/jquery.placeholder',
			'jquery/plugins/jquery.selso',
			'jquery/plugins/jquery.disable.text.select.pack',
			'jquery/plugins/jquery.supercomboselect',
			'jquery/plugins/jquery.MultiFile',
			'saisai/linked_field_formatters',
			'jquery/plugins/jquery.numeric',
			'jquery/plugins/jquery.repeatable',

			// NASTY Chrome JS bug...
			// http://stackoverflow.com/questions/10314992/chrome-sometimes-calls-incorrect-constructor
			// http://stackoverflow.com/questions/10251272/what-could-cause-this-randomly-appearing-error-inside-jquery-itself
			'jquery/plugins/chrome_pushstack_fix',
			'jqx/plugins/util',
			'saisai/global',
		);
	
		
		$js_inline = array(
				'jquery/plugins/jquery.form', 
				'jquery/plugins/jqModal', 
				'jquery/plugins/jquery.serialize', 
				'jquery/plugins/jquery.cookie', 
				'jquery/plugins/jquery.supercookie', 
				'jquery/plugins/jquery.ba-resize.min', 
				'saisai/global',
				'saisai/edit_mode'
		);


		// set the folder in which to place the file
		$output_params['type'] = 'js';
		$output_params['whitespace'] = TRUE;
		$output_params['destination'] = assets_server_path('saisai/saisai.min.js', 'js', SAISAI_FOLDER);
		$output_params['module'] = SAISAI_FOLDER;
		$output = $this->asset->optimize($js, $output_params);

		$output_params['destination'] = assets_server_path('saisai/saisai_inline.min.js', 'js', SAISAI_FOLDER);
		$output = $this->asset->optimize($js_inline, $output_params);

		echo lang('module_build_asset', 'JS', $output_params['destination']);
	}

	function optimize_css()
	{
		$css = array(
			'jqmodal',
			'jquery.tooltip', 
			'jquery.treeview',
			'jquery.supercomboselect',
			'markitup',
			'jquery-ui-1.8.17.custom',
			'saisai'
		);
	
		// set the folder in which to place the file
		$output_params['type'] = 'css';
		$output_params['whitespace'] = TRUE;
		$output_params['destination'] = assets_server_path('saisai.min.css', 'css', SAISAI_FOLDER);
		$output_params['module'] = SAISAI_FOLDER;

		$output = $this->asset->optimize($css, $output_params);
		echo lang('module_build_asset', 'CSS', $output_params['destination']);
	}
}