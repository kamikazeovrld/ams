<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * SAISAI CMS
 * http://www.saisai.co
 *
 * An open source Content Management System based on the 
 * Codeigniter framework (http://codeigniter.com)
 *
 * @package		SAISAI CMS
 * @author		Jabulani Mpofu @ Saisai
 * @copyright	Copyright (c) 2010, Run for Daylight LLC.
 * @license		http://www.saisai.co/general/license
 * @link		http://www.saisai.co
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Session Helper
 *
 * @package		SAISAI CMS
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Jabulani Mpofu @ Saisai
 * @link		http://docs.saisai.co/helpers/session_helper
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