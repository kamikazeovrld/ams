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
 * @copyright	Copyright (c) 2014, Run for Daylight LLC.
 * @license		http://www.saisai.co/general/license
 * @link		http://www.saisai.co
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * SAISAI Ajax Helper
 *
 * Helper function for AJAX requests.
 *
 * @package		SAISAI CMS
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Jabulani Mpofu @ Saisai
 * @link		http://docs.saisai.co/helpers/ajax_helper
 */


// --------------------------------------------------------------------

/**
 * Returns a boolean value based on whether the page was requested via AJAX or not
 *
 * @access	public
 * @return	boolean
 */	
function is_ajax(){
	return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=="XMLHttpRequest");
}

// --------------------------------------------------------------------

/**
 * Sets the HTTP headers for 
 *
 * @access	public
 * @param	boolean	Sets the no cache headers
 * @return	boolean
 */	
function json_headers($no_cache = TRUE)
{
	if ($no_cache)
	{
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	}
	header('Content-type: application/json');
}

/* End of file ajax_helper.php */
/* Location: ./modules/saisai/helpers/ajax_helper.php */
