<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * SAISAI CMS
 * http://www.saisai.co
 *
 * An open source Content Management System based on the 
 * Codeigniter framework (http://codeigniter.com)
 *
 * @package		SAISAI CMS
 * @author		David McReynolds @ Saisai
 * @copyright	Copyright (c) 2014, Run for Daylight LLC.
 * @license		http://www.saisai.co/general/license
 * @link		http://www.saisai.co
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * SAISAI base controller object
 *
 * @package		SAISAI CMS
 * @subpackage	Libraries
 * @category	Libraries
 * @author		David McReynolds @ Saisai
 * @link		http://docs.saisai.co/libraries/saisai_base_controller
 * @autodoc		FALSE
 */

// --------------------------------------------------------------------

define('SAISAI_ADMIN', TRUE);

class Saisai_base_controller extends CI_Controller {
	
	public $js_controller = 'saisai.controller.BaseSaisaiController'; // The default jQX controller
	public $js_controller_params = array(); // jQX controller parameters
	public $js_controller_path = ''; // The path to the jQX controllers. If blank it will load from the saisai/modules/saisai/assets/js/jqx/ directory
	public $nav_selected; // the navigation item in the left menu to show selected
	public $saisai; // the SAISAI master object
	
	// --------------------------------------------------------------------
	
	/**
	 * Constructor
	 *
	 * @access	public
	 * @param	boolean	Determines whether to validate the user or not (optional)
	 * @return	void
	 */	
	public function __construct($validate = TRUE)
	{
		parent::__construct();
		
		$this->saisai->admin->initialize(array('validate' => $validate));
		
		if (method_exists($this, '_init'))
		{
			$this->_init();
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Resets the page state for the current page by default
	 *
	 * @access	public
	 * @param	string (optional)
	 * @return	void
	 */	
	public function reset_page_state($state_key = NULL)
	{
		if (empty($state_key))
		{
			$state_key = $this->saisai->admin->get_state_key();
		}
		if (!empty($state_key))
		{
			$session_key = $this->saisai->auth->get_session_namespace();
			$user_data = $this->saisai->auth->user_data();
			$user_data['page_state'] = array();
			$this->session->set_userdata($session_key, $user_data);
			redirect(saisai_url($state_key));
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Validates that the currently logged in user has the proper permissions to view the current page
	 *
	 * @access	public
	 * @param	string The name of the permission to check for the currently logged in user
	 * @param	string The type of permission (e.g. publish, edit, delete) (optional)
	 * @param	boolean Determines whether to show a 404 error or to just exit. Default is to show a 404 error(optional)
	 * @return	void
	 */	
	protected function _validate_user($permission, $type = '', $show_error = TRUE)
	{
		if (!$this->saisai->auth->has_permission($permission, $type))
		{
			if ($show_error)
			{
				show_error(lang('error_no_access'));
			}
			else
			{
				exit();
			}
		}
	}
}

/* End of file Saisai_base_controller.php */
/* Location: ./modules/saisai/libraries/Saisai_base_controller.php */