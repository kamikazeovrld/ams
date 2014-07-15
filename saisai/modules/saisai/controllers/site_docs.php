<?php
require_once(SAISAI_PATH.'/libraries/Saisai_base_controller.php');

class Site_docs extends Saisai_base_controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->_validate_user('site_docs');
	}
	
	public function _remap()
	{
		if ($this->saisai->modules->exists('user_guide') AND defined('USER_GUIDE_FOLDER'))
		{
			$this->load->helper(USER_GUIDE_FOLDER, 'user_guide');
		}
		
		$this->load->helper('text');
		$page = uri_path(TRUE, 1);

		if (empty($page)) $page = 'index';
		$this->saisai->pagevars->vars_path = APPPATH.'views/_variables/';
		$this->saisai->pagevars->location = $page;
		
		$vars = $this->saisai->pagevars->view('site_docs');
		$vars['body'] = 'index';

		// render page
		if (file_exists(APPPATH.'/views/_docs/'.$page.'.php'))
		{
			// use app module which is the application directory
			$vars['body'] = $this->load->module_view('app', '_docs/'.$page, $vars, TRUE);
			
			// get layout page
			if (file_exists(APPPATH.'views/_layouts/documentation.php'))
			{
				$this->load->module_view(NULL, '_layouts/documentation', $vars);
			}
			else if (file_exists(SAISAI_PATH.'views/_layouts/documentation'.EXT))
			{
				$vars['page_title'] = $this->config->item('site_name', 'saisai');
				$this->load->view('_layouts/documentation', $vars);
			}
			else
			{
				$this->output->set_output($vars['body']);
			}
		}
		else
		{
			show_404();
		}
		
		
	}
}