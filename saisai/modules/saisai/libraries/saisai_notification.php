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
 */

// ------------------------------------------------------------------------

/**
 * SAISAI notification object
 *
 * @package		SAISAI CMS
 * @subpackage	Libraries
 * @category	Libraries
 * @author		David McReynolds @ Saisai
 * @link		http://docs.saisai.co/libraries/saisai_notification
 */

// --------------------------------------------------------------------

class Saisai_notification extends Saisai_base_library {

	public $to = ''; // the to address to send the notification
	public $from = ''; // the from address of the sender
	public $from_name = ''; // the from name of the sender
	public $subject = ''; // the subject line of the notification
	public $message = ''; // the message
	public $attachments = array(); // attachments
	public $use_dev_mode = TRUE; // whether to use dev mode or not which means it will send to the dev_email address in the config

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
	 * Sends an email message
	 *
	 * @access	public
	 * @param	array	Email preferences (optional)
	 * @return	boolean
	 */	
	public function send($params = array())
	{
		// set defaults for from and from name
		if (empty($params['from']))
		{
			$params['from'] = $this->saisai->config('from_email');
		}

		if (empty($params['from_name']))
		{
			$params['from_name'] = $this->saisai->config('site_name');
		}

		// set any parameters passed
		$this->set_params($params);
		
		// load email and set notification properties
		$this->CI->load->library('email');
		$this->CI->email->set_wordwrap(TRUE);
		$this->CI->email->from($this->from, $this->from_name);
		$this->CI->email->subject($this->subject);
		$this->CI->email->message($this->message);
		if (!empty($this->attachments))
		{
			if (is_array($this->attachments))
			{
				foreach($this->attachments as $attachment)
				{
					$this->CI->email->attach($attachment);
				}
			}
			else
			{
				$this->CI->email->attach($this->attachments);
			}
		}
		
		// if in dev mode then we send it to the dev email if specified
		if ($this->is_dev_mode())
		{
			$this->CI->email->to($this->CI->config->item('dev_email'));
		}
		else
		{
			$this->CI->email->to($this->to);
		}
		
		if (!$this->CI->email->send())
		{
			$this->_errors[] = $this->CI->email->print_debugger();
			return FALSE;
		}
		return TRUE;
		
	}

	// --------------------------------------------------------------------
	
	/**
	 * Converts an array of data (e.g. $_POST) into a key value message format
	 *
	 * Used for form submissions
	 *
	 * @access	public
	 * @param	array	An array of data to humanize and turn into a message
	 * @param	string	An intro message to place before the data (optional)
	 * @return	string
	 */	
	public function data_message($data, $intro = '')
	{
		$msg = $intro."\n\n";
		if (!empty($data))
		{
			if (is_object($data) AND is_a($data, 'Data_record'))
			{
				$data = $data->values();
			}

			foreach ($data as $key => $val)
			{
				$msg .= humanize($key) . ': ' . $val . "\n";
			}
		}
		return $msg;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Determines if the site is in dev mode and whether "use_dev_mode" is specified as TRUE on the object
	 *
	 * @access	public
	 * @return	boolean
	 */	
	public function is_dev_mode()
	{
		return $this->use_dev_mode == TRUE AND (is_dev_mode());
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Returns an array of error messages if any were set
	 *
	 * @access	public
	 * @return	array
	 */	
	public function errors()
	{
		return $this->_errors;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Determines whether there are any errors on the object
	 *
	 * @access	public
	 * @return	boolean
	 */	
	public function has_errors()
	{
		return (count($this->_errors) > 0);
	}

}


/* End of file Saisai_notification.php */
/* Location: ./modules/saisai/libraries/Saisai_notification.php */