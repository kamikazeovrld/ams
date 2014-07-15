<?php
class Reset extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->config->load('saisai', true);
	}
	
	public function _remap($method)
	{
		if (!$this->config->item('allow_forgotten_password', 'saisai')) show_404();
		$this->load->library('session');
		$this->load->helper('string');
		
		$this->load->module_model(SAISAI_FOLDER, 'saisai_users_model');
		$this->load->module_language(SAISAI_FOLDER, 'saisai');
		
		$email = saisai_uri_segment(2);
		$reset_key = saisai_uri_segment(3);
		$user = $this->saisai_users_model->find_one('MD5(email) = "'.$email.'" AND MD5(reset_key) = "'.$reset_key.'"');
		if (isset($user->id))
		{
			$new_pwd = random_string('alnum', 8);
			
			$user->password = $new_pwd;
			$user->reset_key = '';
			if ($user->save())
			{
				$params['to'] = $user->email;
				$params['subject'] = lang('pwd_reset_subject_success');
				$params['message'] = lang('pwd_reset_email_success', $new_pwd);
				$params['use_dev_mode'] = FALSE;
				
				if ($this->saisai->notification->send($params))
				{
					$this->session->set_flashdata('success', lang('pwd_reset_success'));
					$this->saisai->logs->write(lang('auth_log_pass_reset', $user->user_name, $this->input->ip_address()), 'debug');
				}
				else
				{
					$this->session->set_flashdata('error', $this->email->print_debugger());
				}
			}
			else
			{
				$this->session->set_flashdata('error', lang('error_pwd_reset'));
			}
		}
		else
		{
			$this->session->set_flashdata('error', lang('error_pwd_reset'));
		}
		redirect(saisai_url('login'));
		
	}

}