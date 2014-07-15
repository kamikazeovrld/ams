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
 * SAISAI master object
 *
 * The master SAISAI object that other objects attach to
 *
 * @package		SAISAI CMS
 * @subpackage	Libraries
 * @category	Libraries
 * @author		David McReynolds @ Daylight Studio
 * @link		http://docs.getsaisaicms.com/libraries/saisai
 */

// --------------------------------------------------------------------

// include base library classes to extend
require_once('Saisai_base_library.php');
require_once('Saisai_advanced_module.php');
require_once('Saisai_modules.php');

class Saisai extends Saisai_advanced_module {
	protected $name = 'SAISAI'; // name of the advanced module... usually the same as the folder name
	protected $folder = 'saisai'; // name of the folder for the advanced module
	
	 // attached objects
	protected $_attached = array();
	
	 // objects to automatically attach
	protected $_auto_attach = array(
									'admin',
									'assets',
									'auth',
									'blocks',
									'cache',
									'categories',
									'installer',
									'language',
									'layouts',
									'logs',
									'modules',
									'navigation',
									'notification',
									'pages',
									'pagevars',
									'permissions',
									'redirects',
									'settings',
									'sitevars',
									'tags',
									'users',
									);

	// the singleton instance
	private static $_instance;
	
	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		parent::__construct();
		self::$_instance =& $this;
		$this->saisai =& self::$_instance; // for compatibility
		$this->initialize();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Static method that returns the instance of the SAISAI object.
	 *
	 * This object is auto-loaded and so you will most likely use $this->saisai instead of this method
	 *
	 * @access	public
	 * @return	object	
	 */	
	public static function &get_instance()
	{
		return self::$_instance;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Initialize the SAISAI object
	 *
	 * Accepts an associative array as input containing the SAISAI config parameters to set
	 *
	 * @access	public
	 * @param	array	Config preferences
	 * @return	void
	 */	
	public function initialize($config = array())
	{
		// load main saisai config
		$this->CI->load->module_config(SAISAI_FOLDER, 'saisai', TRUE);

		if (!empty($config))
		{
			$this->set_config($config);
		}
		
		$this->_config = $this->CI->config->config['saisai'];
		
		// merge in any "attach" objects to include on the SAISAI object
		$this->_auto_attach = array_merge($this->_auto_attach, $this->_config['attach']);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Sets a configuration value for SAISAI (overwrites Saisai_advanced_module)
	 *
	 * @access	public
	 * @param	mixed	Can be a string that references the configuration key or an array of values
	 * @param	mixed	The value of the key configuration item (only works if $item parameter is not an array) (optional)
	 * @param	string	The module to set the configuration item. Default is saisai. (optional)
	 * @return	void
	 */	
	public function set_config($item, $value = NULL, $module = 'saisai')
	{
		$saisai_config = $this->CI->config->item($module);
		if (is_array($item))
		{
			foreach($item as $key => $val)
			{
				$saisai_config[$key] = $val;
			}
		}
		else
		{
			$saisai_config[$item] = $value;
		}
		$this->_config[$item] = $value;
		$this->CI->config->set_item($module, $saisai_config);
	}

// --------------------------------------------------------------------
	
	/**
	 * Returns the SAISAI version
	 *
	 * @access	public
	 * @param	string	Value of what part of the version number to return. Options are "major", "minor", or "patch" (optional)
	 * @return	void
	 */	
	public function version($part = NULL)
	{
		$version = SAISAI_VERSION;
		if (!empty($part))
		{
			$parts = explode('.', $version);
			switch($part)
			{
				case 'major':
					return $parts[0];
					break;
				case 'minor':
					if (isset($parts[1])) return $parts[1];
					break;
				case 'patch':
					if (isset($parts[2])) return $parts[2];
					break;
			}
			return '0';
		}
		return $version;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Magic method that will attach and return SAISAI library objects
	 *
	 * @access	public
	 * @param	string	The object
	 * @return	object
	 */	
	public function &__get($var)
	{
		if (!isset($this->_attached[$var]))
		{
			if (in_array($var, $this->_auto_attach))
			{
				$this->attach($var);
			}
			else if ($this->modules->allowed($var))
			{
				$init = array('name' => $var, 'folder' => $var);

				$saisai_class = 'Saisai_'.$var;
				if (file_exists(MODULES_PATH.$var.'/libraries/'.$saisai_class.'.php'))
				{
					$lib_class = strtolower($saisai_class);
					if (!isset($this->CI->$lib_class))
					{
						$this->CI->load->module_library($var, $lib_class, $init);
					}
					return $this->CI->$lib_class;
				}
				else
				{
					$module = new Saisai_advanced_module($init);
					$this->CI->$var = $module;
					return $module;
					
				}
			}
			else
			{
				throw new Exception(lang('error_class_property_does_not_exist', $var));
			}
		}
		return $this->_attached[$var];
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Magic method that will call any methods on an attached object that are "get"
	 *
	 * @access	public
	 * @param	string	The object
	 * @param	string	An array of arguments
	 * @return	object
	 */	
	public function __call($name, $args)
	{
		$obj = $this->$name;
		if (method_exists($obj, 'get'))
		{
			return call_user_func_array(array($obj, 'get'), $args);
		}
		else
		{
			return $obj;
		}
	}
	
}



/* End of file Saisai.php */
/* Location: ./modules/saisai/libraries/Saisai.php */