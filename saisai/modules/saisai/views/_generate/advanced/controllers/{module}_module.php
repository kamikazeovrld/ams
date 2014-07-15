<?php
require_once(SAISAI_PATH.'/libraries/Saisai_base_controller.php');

class {model_name}_module extends Saisai_base_controller {
	
	public $nav_selected = '{module}|{module}/:any';
	

	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$vars['page_title'] = $this->saisai->admin->page_title(array(lang('module_{module}')), FALSE);
		$crumbs = array('tools' => lang('section_tools'), lang('module_{module}'));
		$this->saisai->admin->set_titlebar($crumbs, 'ico_{module}');
		$this->saisai->admin->render('_admin/{module}', $vars);

	}
	
}