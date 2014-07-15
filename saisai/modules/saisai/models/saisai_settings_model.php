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
 */

// ------------------------------------------------------------------------

/**
 * Extends Base_module_model
 *
 * <strong>Saisai_settings_model</strong> is used for managing module specific settings
 * 
 * @package		SAISAI CMS
 * @subpackage	Models
 * @category	Models
 * @author		David McReynolds @ Daylight Studio
 * @link		http://docs.getsaisaicms.com/models/saisai_settings_model
 */

require_once('base_module_model.php');

class Saisai_settings_model extends Base_module_model
{
	public $required = array('key'); // The key setting value is required
	public $serialized_fields = array('value'); // All values are 
	
	// --------------------------------------------------------------------
	
	/**
	 * Constructor.
	 *
	 * @access	public
	 * @return	void
	 */	
	public function __construct()
	{
		parent::__construct('saisai_settings');
	}
}


class Saisai_setting_model extends Base_module_record {
}
