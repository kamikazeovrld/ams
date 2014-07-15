<?php
require_once(SAISAI_PATH.'/libraries/Saisai_base_controller.php');

class Manage extends Saisai_base_controller {
	
	public $nav_selected = 'manage';
	public $module_uri = 'manage/activity';
	
	public function __construct()
	{
		parent::__construct(FALSE);
		$this->js_controller = 'saisai.controller.ManageController';
	}
	
	public function index()
	{
		$this->_validate_user('manage');
		$crumbs = array(lang('section_manage'));
		$this->saisai->admin->set_titlebar($crumbs);
		$this->saisai->admin->render('manage');
	}
	
	public function cache()
	{
		$this->_validate_user('manage/cache');	

		// to display the logout button in the top right of the admin
		$load_vars['user'] = $this->saisai->auth->user_data();
		$this->load->vars($load_vars);
		
		$this->saisai->admin->set_nav_selected('manage/cache');
		
		if ($this->input->post('action'))
		{
			$msg = $this->clear_cache(TRUE);
			$this->saisai->admin->set_notification($msg, Saisai_admin::NOTIFICATION_SUCCESS);
			redirect('saisai/manage/cache');
		}
		else 
		{
			$crumbs = array('manage' => lang('section_manage'), lang('module_manage_cache'));

			$this->saisai->admin->set_titlebar($crumbs, 'ico_manage_cache');
			$this->saisai->admin->render('manage/cache');
		}
	}

	public function clear_cache($return = FALSE)
	{
		$remote_ips = $this->saisai->config('webhook_remote_ip');
		$is_web_hook = ($this->saisai->auth->check_valid_ip($remote_ips));

		// check if it is CLI or a web hook otherwise we need to validate
		$validate = (php_sapi_name() == 'cli' OR defined('STDIN') OR $is_web_hook) ? FALSE : TRUE;

		if ($validate)
		{
			$this->_validate_user('manage/cache');
		}

		$this->saisai->cache->clear();
		$msg = lang('cache_cleared');

		$this->saisai->logs->write($msg);
		if ($return)
		{
			return $msg;	
		}
		echo $msg."\n";
	}

}