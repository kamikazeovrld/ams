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
 * SAISAI categories object
 *
 * @package		SAISAI CMS
 * @subpackage	Libraries
 * @category	Libraries
 * @author		David McReynolds @ Saisai
 * @link		http://docs.saisai.co/libraries/saisai_categories
 */

// --------------------------------------------------------------------
class Saisai_categories extends Saisai_module {
	
	protected $module = 'categories';
	
	// --------------------------------------------------------------------
	
	/**
	 * Returns a single category record object based on a slug value
	 *
	 * @access	public
	 * @param	string	the slug value to query on
	 * @return	array
	 */	
	public function find_by_slug($slug)
	{
		$model = $this->model();
		$where['slug'] = $slug;
		$data = $model->find_one($where);
		return $data;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Returns an array of categories record objects based on a context value
	 *
	 * @access	public
	 * @param	string	the context to query on
	 * @return	array
	 */	
	public function find_by_context($context)
	{
		$model = $this->model();
		$where['context'] = $context;
		$data = $model->find_all($where);
		return $data;
	}
	
}

/* End of file Saisai_categories.php */
/* Location: ./modules/saisai/libraries/Saisai_categories.php */