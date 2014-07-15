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
 * Extends Base_module_model
 *
 * <strong>Saisai_tags_model</strong> is used for managing SAISAI tags in the CMS
 * 
 * @package		SAISAI CMS
 * @subpackage	Models
 * @category	Models
 * @author		David McReynolds @ Saisai
 * @link		http://docs.saisai.co/models/saisai_tags_model
 */

require_once('base_module_model.php');

class Saisai_tags_model extends Base_module_model {

	public $filters = array('name', 'slug'); // Allows for filtering on both the name and the slug
	public $unique_fields = array('slug'); // The slug value must be unique
	public $linked_fields = array('name' => 'slug'); // the slug value should be the name field's value with the url_title function applied to it if there is no value specified
	public $foreign_keys = array('category_id' => array(SAISAI_FOLDER => 'saisai_categories_model')); // to create the foreign key association with the saisai_categories model

	protected $friendly_name = 'Tags';
	protected $singular_name = 'Tag';
	
	
	// --------------------------------------------------------------------
	
	/**
	 * Constructor.
	 *
	 * @access	public
	 * @return	void
	 */	
	public function __construct()
	{
		parent::__construct('saisai_tags'); // table name

		$this->init_relationships();
	}

	// --------------------------------------------------------------------
	
	/**
	 * Initializes belongs_to relationship
	 *
	 * @access	public
	 * @return	void
	 */	
	public function init_relationships()
	{
		$CI =& get_instance();

		$modules = $CI->saisai->modules->get(NULL, FALSE);

		$belongs_to = array();

		// loop through all the modules to check for has_many relationships
		unset($modules['tags']);
		foreach($modules as $module)
		{
			// grab each model
			$model = $module->model();
			if (!empty($model->has_many))
			{

				// loop through the has_many relationships to see if any have a "tags" relationship
				foreach($model->has_many as $key => $rel)
				{
					$mod_name = $module->name();
					$model_name = $module->info('model_name');
					$module_location = $module->info('model_location');

					if (is_array($rel))
					{
						if (isset($rel['model']) AND (($rel['model'] == 'tags' OR $rel['model'] == array(SAISAI_FOLDER => 'tags'))
							OR ($rel['model'] == 'saisai_tags_model' OR $rel['model'] == array(SAISAI_FOLDER => 'saisai_tags_model'))))
						{
							$belongs_to[$mod_name] = array('model' => $model_name, 'module' => $module_location);
						}
						else if (current($rel) == 'tags' OR current($rel) == 'saisai_tags_model')
						{
							$belongs_to[$mod_name] = array('model' => $model_name, 'module' => $module_location);
						}
					}
					else if (is_string($rel) AND ($rel == 'tags' OR $rel == 'saisai_tags_model'))
					{
						$belongs_to[$mod_name] = array('model' => $model_name, 'module' => $module_location);
					}
				}
			}
		}

		// set the belongs_to
		$this->belongs_to = $belongs_to;
	}

	/**
	 * Tree view that puts tags in a hierarchy based on their category
	 *
	 * @access	public
	 * @param	boolean 	Determines whether to return just published pages or not (optional... and ignored in the admin)
	 * @return	array 		An array that can be used by the Menu class to create a hierachical structure
	 */	
	public function tree($just_published = FALSE)
	{
		$return = array(); 
		$where = ($just_published) ? array('published' => 'yes') : array();

		$categories = $this->saisai_categories_model->find_all_array($where);

		foreach($categories as $category) 
		{ 
			$return[] = array('id' =>$category['id'], 'label' => $category['name'], 'parent_id' => $category['parent_id'], 'location' => ''); 
			$tags = $this->find_all_array( array('category_id'=>$category['id']), 'name asc' );
			foreach($tags as $tag){
				$return[] = array('id' => $tag['name'], 'label' => $tag['name'], 'parent_id' => $category['id'], 'location' => saisai_url('tags/edit/'.$tag['id']));
			}
			
		}
		return $return;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Creates the form_fields array to be used with Form_builder
	 *
	 * @access	public
	 * @param	array	an array of values to pass to the form fields
	 * @param	array	related field information
	 * @return	array
	 */	
	public function form_fields($values = array(), $related = array())
	{	
		$fields = parent::form_fields($values, $related);
		return $fields;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Overwrites the parent option_list method 
	 *
	 * @access	public
	 * @param	string	the name of the field to be used as the key (optional)
	 * @param	string	the name of the filed to be used as the value (optional)
	 * @param	mixed	the where condition to apply (optional)
	 * @param	mixed	the order in which to return the results (optional)
	 * @return	array 	
	 */	
	public function options_list($key = 'id', $val = 'name', $where = array(), $order = TRUE)
	{
		$this->db->join($this->_tables['saisai_categories'], $this->_tables['saisai_categories'].'.id = '.$this->_tables['saisai_tags'].'.category_id', 'LEFT');

		if (empty($key)) $key = 'id';
		if (empty($val)) $val = 'name';

		// needed to prevent ambiguity
		if (strpos($key, '.') === FALSE)
		{
			$key = $this->_tables['saisai_tags'].'.'.$key;
		}

		// needed to prevent ambiguity
		if (strpos($val, '.') === FALSE)
		{
			$val = $this->_tables['saisai_tags'].'.'.$val;
		}
	
		$options = parent::options_list($key, $val, $where, $order);
		return $options;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Common query to automatically join the categories table
	 *
	 * @access	public
	 * @param mixed parameter to pass to common query (optional)
	 * @return	void 	
	 */		
	public function _common_query($params = NULL)
	{
		parent::_common_query();
		$this->db->join($this->_tables['saisai_categories'], $this->_tables['saisai_categories'].'.id = '.$this->_tables['saisai_tags'].'.category_id', 'LEFT');
	}

}

class Saisai_tag_model extends Base_module_record {
	
}