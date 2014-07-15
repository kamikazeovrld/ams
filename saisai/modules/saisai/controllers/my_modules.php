<?php
require_once(SAISAI_PATH.'/libraries/Saisai_base_controller.php');

class My_modules extends Saisai_base_controller {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$vars['modules'] = $this->saisai->modules->advanced();
		$crumbs = array(lang('section_my_modules'));
		$this->saisai->admin->set_titlebar($crumbs);
		
		$this->saisai->admin->render('manage/my_modules', $vars);
	}
	
	public function install($module = NULL)
	{
		
		$module = 'test';
		//$this->saisai->modules->install($module);
		$this->saisai->install->activate('backup');
	}
	
	public function uninstall($module = NULL)
	{
		$this->saisai->set_module($module);
		//$this->saisai->install->deactivate();
		$this->saisai->$module->deactivate();
	}

	
}