<?php
require_once(SAISAI_PATH.'/libraries/Saisai_base_controller.php');

class Recent extends Saisai_base_controller {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$session_key = $this->saisai->auth->get_session_namespace();
		$user_data = $this->saisai->auth->user_data();
		if (!empty($user_data['last_page']))
		{
			
			$redirect_to = $user_data['last_page'];
		}
		else
		{
			$redirect_to = $this->config->item('saisai_path', 'saisai').'dashboard';
		}
		redirect($redirect_to);
	}
}