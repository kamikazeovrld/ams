<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * SAISAI CMS
 * http://www.getsaisaicms.com
 *
 * An open source Content Management System based on the 
 * Codeigniter framework (http://codeigniter.com)
 *
 * @package		SAISAI CMS
 * @author		David McReynolds @ Daylight Studio
 * @copyright	Copyright (c) 2014, Run for Daylight LLC.
 * @license		http://docs.getsaisaicms.com/general/license
 * @link		http://www.getsaisaicms.com
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * SAISAI users object
 *
 * @package		SAISAI CMS
 * @subpackage	Libraries
 * @category	Libraries
 * @author		David McReynolds @ Daylight Studio
 * @link		http://docs.getsaisaicms.com/libraries/saisai_users
 */

// --------------------------------------------------------------------

class Saisai_users extends Saisai_module {

	protected $module = 'users';

	public function initialize($params = array())
	{
		parent::initialize($params);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Returns a user provided a user ID
	 *
	 * @access	public
	 * @param	mixed
	 * @param	string
	 * @return	string
	 */
	public function get($user_id, $return_type = NULL)
	{
		if (is_int($user_id))
		{
			$user = $this->model()->find_by_key($user_id, $return_type);
		}
		else
		{
			$user = $this->model()->find_one('(user_name = "'.$user_id.'" OR email = "'.$user_id.'")', 'id', $return_type);
		}
		return $user;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Assigns a permission to a user
	 *
	 * @access	public
	 * @param	mixed
	 * @return	string
	 */
/*	function assign_permissions_to_user($perms, $user_id)
	{
		foreach($perms as $perm)
		{
			if (!$this->assign_permission_to_user($perm, $user_id))
			{
				$this->_add_error(lang('error_saving'));
			}
		}
		return $this->has_errors();
	}*/

	// --------------------------------------------------------------------

	/**
	 * Assigns a permission to a user
	 *
	 * @access	public
	 * @param	mixed
	 * @return	string
	 */
/*	function assign_permission_to_user($perm_id, $user_id)
	{
		$this->saisai->load_model('permissions');
		$user = $this->get($user_id);
		$permissions = array();
		$user->permissions = $permissions;
		$user->save();
		if (!isset($user->id)) return FALSE;

		$permission = $this->saisai->permissions->get($perm_id);
		if (!isset($permission->id)) return FALSE;
		
		$perm_to_user = $this->CI->user_to_permissions_model->create();
		$perm_to_user->permission_id = $user->id;
		$perm_to_user->user_id = $user->id;
		return $perm_to_user->save();
	}*/

	// --------------------------------------------------------------------

	/**
	 * Resets a user's password given their email
	 *
	 * @access	public
	 * @param	mixed
	 * @return	string
	 */
	public function reset_password($email)
	{
		// make sure user exists when saving
		$model = &$this->model();
		return $model->reset_password($email);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Checks to see if a user exists based on a user_name or email
	 *
	 * @access	public
	 * @param	mixed
	 * @return	string
	 */
	public function user_exists($email)
	{
		return $this->record_exists(array('email' => $email));
	}
	
	// --------------------------------------------------------------------

	/**
	 * Sends the welcome email to a user
	 *
	 * @access	public
	 * @param	mixed
	 * @return	string
	 */
	public function send_email($user_id)
	{
		$user = $this->get($user_id, 'array');
		
		$params['to'] = $user['email'];
		$params['message'] = lang('new_user_email', site_url('saisai/login'), $user['user_name'], $user['password']);
		$params['subject'] = lang('new_user_email_subject');
		$params['use_dev_mode'] = FALSE; // must be set for emails to always go

		if (!$this->saisai->notification->send($params))
		{
			$this->_add_error(lang('error_sending_email'));
			return FALSE;
		}
		return TRUE;
	}
	
}

/* End of file Saisai_users.php */
/* Location: ./modules/saisai/libraries/Saisai_users.php */