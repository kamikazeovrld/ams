<?php

require_once(SAISAI_PATH.'/libraries/Saisai_base_controller.php');

class Settings extends Saisai_base_controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->_validate_user('settings');

		$crumbs = array(lang('section_settings'));
		$this->saisai->admin->set_titlebar($crumbs);
	}

	public function index()
	{
		$this->_validate_user('settings');
		
		$settings = array();
		$modules = $this->saisai->modules->advanced(TRUE);
		foreach ($modules as $key => $module)
		{
			if ($module->has_settings())
			{
				$settings[$module->name()] = $module;
			}
		}
		$vars['settings'] = $settings;
		
		
		$crumbs = array(lang('section_settings'));
		$this->saisai->admin->set_titlebar($crumbs, 'ico_settings');
		
		$this->saisai->admin->render('settings', $vars);
	}

	public function manage($module = '')
	{
		if (empty($module))
		{
			redirect('saisai/settings');
		}
		
		if (!empty($module) AND $module != SAISAI_FOLDER)
		{
			$mod_install_config = $this->saisai->installer->config($module);
			if (isset($mod_install_config['permissions']))
			{
				$perm = $mod_install_config['permissions'];
				if (is_array($perm))
				{
					if (count($perm) > 1)
					{
						if (isset($perm[$module.'/settings']))
						{
							$this->_validate_user($module.'/settings');
						}
						else
						{
							$this->_validate_user($module);
						}
					}
					else
					{
						$perm = (is_int(key($perm))) ? current($perm) : key($perm);
						$this->_validate_user($perm);
					}
				}
				else
				{
					$this->_validate_user($perm);
				}
			}
		}

		$this->js_controller_params['method'] = 'add_edit';
		
		$mod = $this->saisai->modules->get($module);

		$settings = $this->saisai->modules->get($module)->settings_fields();
		
		if (empty($settings)) 
		{
			show_error(lang('settings_problem', $module, $module, $module));
		}
		
		
		$this->load->library('form_builder');
		$this->form_builder->load_custom_fields(APPPATH.'config/custom_fields.php');


		if (!empty($_POST))
		{
			$new_settings = $this->input->post('settings', TRUE);

			$fields = $settings;
			$this->form_builder->set_fields($fields);
			$new_settings = $this->form_builder->post_process_field_values($new_settings);// manipulates the $_POST values directly
			if ($this->saisai->settings->process($module, $settings, $new_settings))
			{
				$this->saisai->cache->clear_module($module);
				$this->session->set_flashdata('success', lang('data_saved'));
				redirect($this->uri->uri_string());
			}
		}

		
		$field_values = $this->saisai->settings->get($module);

		
		$this->form_builder->label_layout = 'left';
		$this->form_builder->form->validator = $this->saisai->settings->get_validation();
		$this->form_builder->use_form_tag = FALSE;
		$this->form_builder->set_fields($settings);
		$this->form_builder->display_errors = FALSE;
		$this->form_builder->name_array = 'settings';
		$this->form_builder->submit_value = 'Save';
		$this->form_builder->set_field_values($field_values);
		
		$vars = array();
		$vars['module'] = $mod->friendly_name();
		$vars['form'] = $this->form_builder->render();
		
		$crumbs = array('settings' => lang('section_settings'), $mod->friendly_name());
		$this->saisai->admin->set_titlebar($crumbs, 'ico_settings');
		
		$this->saisai->admin->render('manage/settings', $vars, Saisai_admin::DISPLAY_NO_ACTION);
	}

}