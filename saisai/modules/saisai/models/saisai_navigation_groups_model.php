<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
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
 * Extends Base_module_model
 *
 * <strong>Saisai_navigation_groups_model</strong> is used for managing SAISAI users in the CMS
 * 
 * @package		SAISAI CMS
 * @subpackage	Models
 * @category	Models
 * @author		David McReynolds @ Saisai
 * @link		http://docs.saisai.co/models/saisai_navigation_groups_model
 */

require_once('base_module_model.php');

class Saisai_navigation_groups_model extends Base_module_model {
	
	public $unique_fields = array('name'); // The name field is unique
	
	// --------------------------------------------------------------------
	
	/**
	 * Constructor.
	 *
	 * @access	public
	 * @return	void
	 */	
	public function __construct()
	{
		$CI =& get_instance();
		$tables = $CI->config->item('tables', 'saisai');
		parent::__construct($tables['saisai_navigation_groups']);
		$this->add_validation('name', array(&$this, 'valid_name'), lang('error_requires_string_value'));
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Validation callback function. Navigation group names must not be numeric.
	 *
	 * @access	public
	 * @param	string
	 * @return	boolean
	 */	
	public function valid_name($name)
	{
		return (!is_numeric($name));
	}

	// --------------------------------------------------------------------
	
	/**
	 * Cleanup navigation items if group is deleted
	 *
	 * @access	public
	 * @param	mixed The where condition for the delete
	 * @return	void
	 */	
	 public function on_after_delete($where)
	 {
		$this->delete_related(array(SAISAI_FOLDER => 'saisai_navigation_model'), 'group_id', $where);
	 }
}

class Saisai_navigation_group_model extends Base_module_record {
}
