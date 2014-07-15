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
 * SAISAI settings object
 *
 * @package		SAISAI CMS
 * @subpackage	Libraries
 * @category	Libraries
 * @author		David McReynolds @ Daylight Studio
 * @link		http://docs.getsaisaicms.com/libraries/saisai_settings
 */

// --------------------------------------------------------------------

class Saisai_settings extends Saisai_base_library {

	protected $settings = array(); // Settings array of Form_builder form fields
	
	public function __construct($params = array())
	{
		parent::__construct($params);
		$this->saisai->load_model('saisai_settings');
	}

	// --------------------------------------------------------------------

	/**
	 * Returns an array of settings related to a particular module
	 *
	 * @access public
	 * @param string $module, Module name
	 * @param string $key, Key name
	 * @return array
	 */
	public function get($module, $key = '')
	{
		if ( ! array_key_exists($module, $this->settings))
		{
			$tables = $this->CI->saisai_settings_model->tables();
			$this->settings[$module] = $this->CI->saisai_settings_model->options_list($tables['saisai_settings'].'.key', $tables['saisai_settings'].'.value', array('module' => $module), 'key');
			foreach($this->settings[$module] as $k => $v)
			{
				$this->settings[$module][$k] = $this->CI->saisai_settings_model->unserialize_value($this->settings[$module][$k]);
			}

			//$this->settings[$module] = $this->CI->saisai_settings_model->fin_all_array_assoc('saisai_settings.key', array('module' => $module), 'key');
		}
		if ( ! empty($key))
		{
			if (array_key_exists($key, $this->settings[$module]))
			{
				return $this->settings[$module][$key];
			}
			return FALSE;
		}
		else
		{
			return $this->settings[$module];
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Process the new settings & save it to saisai_settings
	 *
	 * @access public
	 * @param string $module, Module name
	 * @param array $settings, An array containing the defined settings
	 * @param array $new_settings, An array containing the new settings
	 * @param boolean $skip_empty_vals, Store empty vals
	 * @return boolean
	 */
	public function process($module, $settings, $new_settings, $skip_empty_vals = FALSE)
	{
		/* if (isset($module, $settings, $new_settings)) */
		if ( ! empty($new_settings) AND ! empty($module) AND ! empty($settings))
		{
			// backup old settings
			$this->model()->update(array('module' => "{$module}_backup"), array('module' => $module));
//			$this->CI->saisai_settings_model->debug_query();


			// format data for saving
			$save = array();
			foreach ($settings as $key => $field_config)
			{
				$new_value = '';
				// set checkbox settings to 0 by default if unchecked
				if (array_key_exists('type', $field_config) AND  ! array_key_exists($key, $new_settings))
				{	
					if ($field_config['type'] == 'checkbox')
					{
						$new_value = 0;
					}
					else
					{
						$new_value = array();
					}
				}
				else if (isset($new_settings[$key]))
				{
					//$new_value = trim($new_settings[$key]);
					$new_value = $new_settings[$key];
					if ($skip_empty_vals AND empty($new_value))
					{
						continue;
					}
				}
				$save[] = array(
					'module' => $module,
					'key'    => $key,
					'value'  => $new_value,
					);
			}
			if ( ! empty($save))
			{
				$this->save($save);
				
				// clear out old settings
				$this->delete(array('module' => "{$module}_backup"));
			
				return TRUE;
			}
		}
		return FALSE;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Returns the saisai_settings_model's validation
	 *
	 * @access	public
	 * @return	object
	 */
	public function get_validation()
	{
		$validation = &$this->CI->saisai_settings_model->get_validation();
		return $validation;
	}
	
	
	// --------------------------------------------------------------------
	
	/**
	 * Returns the SAISAI logs_model object
	 *
	 * @access	public
	 * @return	object
	 */
	public function &model()
	{
		return $this->CI->saisai_settings_model;
	}

	
	// --------------------------------------------------------------------
	
	/**
	 * Saves settings to the database
	 *
	 * @access	public
	 * @param	mixed 	Either an array of data to save or a string value of the module to associate with this setting (must pass additional parameters if a string)
	 * @param	string 	The key setting value (required if first parameter is a string)
	 * @param	mixed 	The value of the setting (required if first parameter is a string)
	 * @return	boolean
	 */
	public function save($module, $key = NULL, $value = NULL)
	{
		if (is_string($module))
		{
			$save = array(
				'module' => $module,
				'key'    => $key,
				'value'  => $value,
				);
		}
		else
		{
			$save = $module;
		}
		return $this->model()->save($save);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Deletes settings to the database
	 *
	 * @access	public
	 * @param	array 	Array of where conditions to delete
	 * @return	boolean
	 */
	public function delete($where)
	{
		return $this->model()->delete($where);
	}
	
	
}

/* End of file Saisai_settings.php */
/* Location: ./modules/saisai/libraries/Saisai_settings.php */