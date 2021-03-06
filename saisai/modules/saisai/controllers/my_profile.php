<?php
require_once(SAISAI_PATH.'/libraries/Saisai_base_controller.php');

class My_profile extends Saisai_base_controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->module_model(SAISAI_FOLDER, 'saisai_users_model');
	}
	
	public function edit()
	{
		
		$user = $this->saisai->auth->user_data();
		$id = $user['id'];
		
		if (!empty($_POST))
		{
			if ($id)
			{
				if ($this->saisai_users_model->save())
				{
					$this->saisai->admin->set_notification(lang('data_saved'), Saisai_admin::NOTIFICATION_SUCCESS);
					redirect(saisai_uri('my_profile/edit/'));
				}
			}
		}
		$this->_form($id);
	}

	// seperated to make it easier in subclasses to use the form without rendering the page
	public function _form($id = null)
	{
		$this->load->library('form_builder');
		$this->js_controller_params['method'] = 'add_edit';
		
		// create fields... start with the table info and go from there
		$values = array('id' => $id);
		$fields = $this->saisai_users_model->form_fields($values);
		
		// remove permissions
		unset($fields['permissions']);
		
		// get saved data
		$saved = array();
		if (!empty($id))
		{
			$saved = $this->saisai_users_model->user_info($id);
		}

		// remove active from field list to prevent them from updating it
		unset($fields['active'], $fields['Permissions']);

		
		if (!empty($_POST))
		{
			$field_values = $this->saisai_users_model->clean();
		}
		else
		{
			$field_values = $saved;
		}
		
		$this->form_builder->form->validator = &$this->saisai_users_model->get_validation();
		$this->form_builder->submit_value = lang('btn_save');
		$this->form_builder->use_form_tag = false;
		$this->form_builder->set_fields($fields);
		$this->form_builder->display_errors = false;
		$this->form_builder->set_field_values($field_values);
		$vars['form'] = $this->form_builder->render();
		
		// other variables
		$vars['id'] = $id;
		$vars['data'] = $saved;
		
		// active or publish fields
		$errors = $this->saisai_users_model->get_errors();
		if (!empty($errors))
		{
			add_errors($errors);	
		}
		
		$this->saisai->admin->set_titlebar_icon('ico_users');
		
		$crumbs = lang('section_my_profile');
		$this->saisai->admin->set_titlebar($crumbs);
		$this->saisai->admin->render('my_profile', $vars);
	}
	
}