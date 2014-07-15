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
 * @copyright	Copyright (c) 2010, Run for Daylight LLC.
 * @license		http://docs.getsaisaicms.com/general/license
 * @link		http://www.getsaisaicms.com
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Session Helper
 *
 * @package		SAISAI CMS
 * @subpackage	Helpers
 * @category	Helpers
 * @author		David McReynolds @ Daylight Studio
 * @link		http://docs.getsaisaicms.com/helpers/session_helper
 */


// --------------------------------------------------------------------

/**
 * Returns a session variable
 *
 * @access	public
 * @param	string	variable name
 * @return	boolean
 */	
function session_userdata($key){
	$CI =& get_instance();
	if (!isset($CI->session))
	{
		$CI->load->library('session');
	}
	return $CI->session->userdata($key);
}

// --------------------------------------------------------------------

/**
 * Sets a session variable
 *
 * @access	public
 * @param	string	variable name
 * @return	boolean
 */	
function session_set_userdata($key, $value){
	$CI =& get_instance();
	if (!isset($CI->session))
	{
		$CI->load->library('session');
	}
	return $CI->session->set_userdata($key, $value);
}

// --------------------------------------------------------------------

/**
 * Returns a session flash variable
 *
 * @access	public
 * @param	string	variable name
 * @return	boolean
 */	
function session_flashdata($key){
	$CI =& get_instance();
	if (!isset($CI->session))
	{
		$CI->load->library('session');
	}

	return $CI->session->flashdata($key);
}

// --------------------------------------------------------------------

/**
 * Sets a session flash variable
 *
 * @access	public
 * @param	string	variable name
 * @return	boolean
 */	
function session_set_flashdata($key, $value){
	$CI =& get_instance();
	if (!isset($CI->session))
	{
		$CI->load->library('session');
	}
	return $CI->session->set_flashdata($key, $value);
}

/* End of file session_helper.php */
/* Location: ./modules/saisai/helpers/session_helper.php */