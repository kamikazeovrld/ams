<?php
require_once(SAISAI_PATH.'/libraries/Saisai_base_controller.php');

class Tools extends Saisai_base_controller {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->_validate_user('tools');
		
		$vars['page_title'] = $this->saisai->admin->page_title(lang('section_tools'), FALSE);
		$this->saisai->admin->set_titlebar(lang('module_tools'), 'ico_tools');
		
		$this->saisai->admin->render('tools', $vars,  Saisai_admin::DISPLAY_NO_ACTION);
	}

}