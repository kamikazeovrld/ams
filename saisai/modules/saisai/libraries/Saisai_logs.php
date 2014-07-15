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
 * SAISAI logs object
 *
 * @package		SAISAI CMS
 * @subpackage	Libraries
 * @category	Libraries
 * @author		David McReynolds @ Saisai
 * @link		http://docs.saisai.co/libraries/saisai_logs
 */

// --------------------------------------------------------------------

class Saisai_logs extends Saisai_base_library {
	
	public $location = 'db'; // the location to write the log. The default is the database. Otherwise it will write to applications logs folder
	
	// --------------------------------------------------------------------
	
	/**
	 * Constructor
	 *
	 * Accepts an associative array as input, containing preferences (optional)
	 *
	 * @access	public
	 * @param	array	config preferences
	 * @return	void
	 */	
	public function __construct($params = array())
	{
		parent::__construct();
		$this->initialize($params);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Initialize the object and set object parameters
	 *
	 * Accepts an associative array as input, containing object preferences.
	 *
	 * @access	public
	 * @param	array	Array of initalization parameters  (optional)
	 * @return	void
	 */	
	public function initialize($params = array())
	{
		parent::initialize($params);
		$this->saisai->load_model('saisai_logs');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Writes a log message to either the database or to a log file
	 *
	 * @access	public
	 * @param	string	Message to log
	 * @param	string	Message level. Options are error, debug, info. Default is 'info'.   (optional)
	 * @param	string	Where to store the log message. Options are 'db' or 'file'. Default is 'db.'  (optional)
	 * @return	void
	 */	
	public function write($msg, $level = 'info', $location = 'db')
	{
		if ($location == 'db')
		{
			$this->CI->saisai_logs_model->logit($msg, $level);
		}
		else
		{
			log_message($level, $msg);
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Returns the SAISAI saisai_logs_model object
	 *
	 * @access	public
	 * @return	object
	 */
	public function &model()
	{
		return $this->CI->saisai_logs_model;
	}
	
}

/* End of file Saisai_logs.php */
/* Location: ./modules/saisai/libraries/Saisai_logs.php */