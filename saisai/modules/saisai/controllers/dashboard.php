<?php
require_once(SAISAI_PATH.'/libraries/Saisai_base_controller.php');

class Dashboard extends Saisai_base_controller {

	public function __construct()
	{
		parent::__construct();
		$this->js_controller = 'saisai.controller.DashboardController';
	}

	public function index()
	{
		if (is_ajax())
		{
			$this->ajax();
		}
		else
		{
			$this->saisai->load_model('saisai_users');
			$auth_user = $this->saisai->auth->user_data();
			$user = $this->saisai_users_model->find_by_key($auth_user['id'], 'array');
			$vars['change_pwd'] = ($user['password'] == $this->saisai_users_model->salted_password_hash($this->config->item('default_pwd', 'saisai'), $user['salt']));

			$dashboards = $this->saisai->admin->dashboards();

			$vars['dashboards'] = $dashboards;
			$crumbs = array('' => 'Dashboard');
			$this->saisai->admin->set_titlebar($crumbs, 'ico_dashboard');
			$this->saisai->admin->render('dashboard', $vars, Saisai_admin::DISPLAY_NO_ACTION);
		}

	}

	/* need to be outside of index so when you click back button it will not show the ajax */
	public function ajax()
	{
		if (is_ajax())
		{
			$this->load->helper('simplepie');
			$this->load->module_model(SAISAI_FOLDER, 'saisai_pages_model');
			$this->load->module_model(SAISAI_FOLDER, 'saisai_logs_model');
			$vars['recently_modifed_pages'] = $this->saisai_pages_model->find_all_array(array(), 'last_modified desc', 10);
			$vars['latest_activity'] = $this->saisai_logs_model->latest_activity(10);
			if (file_exists(APPPATH.'/views/_docs/saisai'.EXT))
			{
				$vars['docs'] = $this->load->module_view(NULL, '_docs/saisai', $vars, TRUE);
			}
			$feed = $this->saisai->config('dashboard_rss');

			$limit = 3;
			$feed_data = simplepie($feed, $limit);

			// check for latest version
			if (array_key_exists('latest_saisai_version', $feed_data) AND version_compare($feed_data['latest_saisai_version'], SAISAI_VERSION, '>'))
			{
				$vars['latest_saisai_version'] = $feed_data['latest_saisai_version'];
			}
			unset($feed_data['latest_saisai_version']);
			$vars['feed'] = $feed_data;
			$this->load->view('dashboard_ajax', $vars);
		}
	}

	public function recent()
	{
		$recent = $this->session->userdata('recent');
		if (!empty($recent[0]))
		{
			$redirect_to = $recent[0]['link'];
		}
		else
		{
			$redirect_to = $this->config->item('saisai_path', 'saisai').'dashboard';
		}
		redirect($redirect_to);
	}


}