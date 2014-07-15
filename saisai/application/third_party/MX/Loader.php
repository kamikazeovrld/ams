<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Modular Extensions - HMVC
 *
 * Adapted from the CodeIgniter Core Classes
 * @link	http://codeigniter.com
 *
 * Description:
 * This library extends the CodeIgniter CI_Loader class
 * and adds features allowing use of modules and the HMVC design pattern.
 *
 * Install this file as application/third_party/MX/Loader.php
 *
 * @copyright	Copyright (c) Wiredesignz 2010-11-12
 * @version 	5.3.5
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 **/

// ------------------------------------------------------------------------

/**
 * Some additions to the  Modular Extension Library
 *
 * Denoted with <!-- SAISAI and SAISAI --> where changes were made
 *
 * @package		SAISAI CMS
 * @subpackage	Third Party
 * @category	Third Party
 * @author		Changes by Jabulani Mpofu @ Saisai.
 */

class MX_Loader extends CI_Loader
{
	private $_module;
	
	public $_ci_plugins;
	
	public function __construct() {
		
		parent::__construct();
	
		/* set the module name for Modular Separation */
		$this->_module = CI::$APP->router->fetch_module();
	}
	
	/** Initialize the loader variables **/
	public function initialize($controller = NULL) {

		parent::__construct();
		if (is_a($controller, 'MX_Controller')) {	

			/* reference to the module controller */
			$this->controller = $controller;

			/* references to ci loader variables */
			foreach (get_class_vars('CI_Loader') as $var => $val) {
				if ($var != '_ci_ob_level') {
					$this->$var =& CI::$APP->load->$var;
				}
			}

		} else {
			parent::initialize();
		}
	
		/* set the module name */
		$this->_module = CI::$APP->router->fetch_module();

		/* add this module path to the loader variables */
		$this->_add_module_paths($this->_module);
	}
	
	
	/** Add a module path loader variables **/
	public function _add_module_paths($module = '') {
		
		if (empty($module)) return;
		
		foreach (Modules::$locations as $location => $offset) {
			
			/* only add a module path if it exists */
			if (is_dir($module_path = $location.$module.'/') && ! in_array($module_path, $this->_ci_model_paths)) 
			{
				array_unshift($this->_ci_model_paths, $module_path);
			}
		}
	}	

	// /** Initialize the module **/
	// public function _init() {
	// 	
	// 	/* set the module name for Modular Extensions */
	// 	$this->_module = CI::$APP->router->fetch_module();
	// 	
	// 	/* references to ci loader variables */
	// 	foreach (get_class_vars('CI_Loader') as $var => $val) {
	// 		$this->$var =& CI::$APP->load->$var;
	//  		}
	// }
	
	/** Load a module config file **/
	public function config($file = '', $use_sections = FALSE, $fail_gracefully = FALSE) {
		return CI::$APP->config->load($file, $use_sections, $fail_gracefully, $this->_module);
	}

	/** Load the database drivers **/
	public function database($params = '', $return = FALSE, $active_record = NULL) {
		if (class_exists('CI_DB', FALSE) AND $return == FALSE AND $active_record == NULL) 
			return;

		require_once BASEPATH.'database/DB'.EXT;

		if ($return === TRUE) 
			return DB($params, $active_record);
			
		CI::$APP->db = DB($params, $active_record);
		if (CI_VERSION < 2) $this->_ci_assign_to_models();
		return CI::$APP->db;
	}

	/** Load a module helper **/
	public function helper($helper) {
		if (is_array($helper)) return $this->helpers($helper);
		
		if (isset($this->_ci_helpers[$helper]))	
			return;

		list($path, $_helper) = Modules::find($helper.'_helper', $this->_module, 'helpers/');

		if ($path === FALSE) 
			return parent::helper($helper);

		Modules::load_file($_helper, $path);
		$this->_ci_helpers[$_helper] = TRUE;
	}

	/** Load an array of helpers **/
	public function helpers($helpers) {
		foreach ($helpers as $_helper) $this->helper($_helper);	
	}

	/** Load a module language file **/
	public function language($langfile, $lang = '', $return = FALSE)	{
		if (is_array($langfile)) return $this->languages($langfile);
		return CI::$APP->lang->load($langfile, $lang, $return, $this->_module);
	}

	/** Load an array of languages **/
	public function languages($languages) {
		foreach ($languages as $_language) $this->language($_language);	
	}
	
	/** Load a module library **/
	public function library($library, $params = NULL, $object_name = NULL) {
		if (is_array($library)) return $this->libraries($library);		
		
		$class = end(explode('/', $library));
		
		if (isset($this->_ci_classes[$class]) AND $_alias = $this->_ci_classes[$class])
			return CI::$APP->$_alias;
			
		($_alias = strtolower($object_name)) OR $_alias = strtolower($class);
		list($path, $_library) = Modules::find($library, $this->_module, 'libraries/');
		
		/* load library config file as params */
		if ($params == NULL) {
			list($path2, $file) = Modules::find($_alias, $this->_module, 'config/');	
			($path2) AND $params = Modules::load_file($file, $path2, 'config');
		}	
			
		if ($path === FALSE) {
			$this->_ci_load_class($library, $params, $object_name);
			$_alias = $this->_ci_classes[$class];
		} else {		
			Modules::load_file($_library, $path);
			$library = ucfirst($_library);
			CI::$APP->$_alias = new $library($params);
			$this->_ci_classes[$class] = $_alias;
		}
		
		if (CI_VERSION < 2) $this->_ci_assign_to_models();
		return CI::$APP->$_alias;
    }

	/** Load an array of libraries **/
	public function libraries($libraries) {
		foreach ($libraries as $_library) $this->library($_library);	
	}

	/** Load a module model **/
	public function model($model, $object_name = NULL, $connect = FALSE) {
		if (is_array($model)) return $this->models($model);

		($_alias = $object_name) OR $_alias = end(explode('/', $model));

		if (in_array($_alias, $this->_ci_models, TRUE)) 
			return CI::$APP->$_alias;
		
		list($path, $model) = Modules::find(strtolower($model), $this->_module, 'models/');
		(CI_VERSION < 2) ? load_class('Model', FALSE) : load_class('Model', 'core');

		if ($connect !== FALSE) {
			if ($connect === TRUE) $connect = '';
			$this->database($connect, FALSE, TRUE);
		}

		Modules::load_file($model, $path);
		$model = ucfirst($model);
		
		CI::$APP->$_alias = new $model();
		if (CI_VERSION < 2) $this->_ci_assign_to_models();
		
		$this->_ci_models[] = $_alias;
		return CI::$APP->$_alias;
	}

	/** Load an array of models **/
	function models($models) {
		foreach ($models as $_model) $this->model($_model);	
	}

	/** Load a module controller **/
	public function module($module, $params = NULL)	{
		if (is_array($module)) return $this->modules($module);

		$_alias = strtolower(end(explode('/', $module)));
		CI::$APP->$_alias = Modules::load(array($module => $params));
		return CI::$APP->$_alias;
	}

	/** Load an array of controllers **/
	public function modules($modules) {
		foreach ($modules as $_module) $this->module($_module);	
	}

	/** Load a module plugin **/
	public function plugin($plugin)	{
		if (is_array($plugin)) return $this->plugins($plugin);		
		
		if (isset($this->_ci_plugins[$plugin]))	
			return;

		list($path, $_plugin) = Modules::find($plugin.'_pi', $this->_module, 'plugins/');	
		
		if ($path === FALSE) return;

		Modules::load_file($_plugin, $path);
		$this->_ci_plugins[$plugin] = TRUE;
	}

	/** Load an array of plugins **/
	public function plugins($plugins) {
		foreach ($plugins as $_plugin) $this->plugin($_plugin);	
	}

	/** Load a module view **/
	public function view($view, $vars = array(), $return = FALSE) {
		list($path, $view) = Modules::find($view, $this->_module, 'views/');
		$this->_ci_view_path = $path;
		return $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_object_to_array($vars), '_ci_return' => $return));
	}

	/** Assign libraries to models **/
	public function _ci_assign_to_models() {
		foreach ($this->_ci_models as $model) {
			CI::$APP->$model->_assign_libraries();
		}
	}

	public function _ci_is_instance() {}

	public function _ci_get_component($component) {
		return CI::$APP->$component;
	}  

	// <!-- SAISAI ... causing problems
	// public function __get($class) {
	// 	return CI::$APP->$class;
	// }
	// SAISAI -->
	
	function _ci_load($_ci_data) {
		
		foreach (array('_ci_view', '_ci_vars', '_ci_path', '_ci_return') as $_ci_val) {
			$$_ci_val = ( ! isset($_ci_data[$_ci_val])) ? FALSE : $_ci_data[$_ci_val];
		}

		if ($_ci_path == '') {
			$_ci_file = strpos($_ci_view, '.') ? $_ci_view : $_ci_view.EXT;
			$_ci_path = $this->_ci_view_path.$_ci_file;
		} else {
			$_ci_file = end(explode('/', $_ci_path));
		}

		if ( ! file_exists($_ci_path)) 
			show_error('Unable to load the requested file: '.$_ci_file);

		if (is_array($_ci_vars)) 
			$this->_ci_cached_vars = array_merge($this->_ci_cached_vars, $_ci_vars);
		
		extract($this->_ci_cached_vars);

		ob_start();

		if ((bool) @ini_get('short_open_tag') === FALSE AND CI::$APP->config->item('rewrite_short_tags') == TRUE) {
			echo eval('?>'.preg_replace("/;*\s*\?>/", "; ?>", str_replace('<?=', '<?php echo ', file_get_contents($_ci_path))));
		} else {
			include($_ci_path); 
		}

		log_message('debug', 'File loaded: '.$_ci_path);

		if ($_ci_return === TRUE) return ob_get_clean();
		
		if (ob_get_level() > $this->_ci_ob_level + 1) {
			ob_end_flush();
		} else {
			CI::$APP->output->append_output(ob_get_clean());
		}
	}	
	
	/** Autload module items **/
	public function _autoloader($autoload) {
		
		$path = FALSE;
		
		if ($this->_module)
			list($path, $file) = Modules::find('autoload', $this->_module, 'config/');

		/* module autoload file */
		if ($path != FALSE)
			$autoload = array_merge(Modules::load_file($file, $path, 'autoload'), $autoload);
	
		/* nothing to do */
		if (count($autoload) == 0) return;
				
		/* autoload config */
		if (isset($autoload['config'])){
			foreach ($autoload['config'] as $key => $val){
				$this->config($val);
			}
		}

		/* autoload helpers, plugins, languages */
		foreach (array('helper', 'plugin', 'language') as $type){
			if (isset($autoload[$type])){
				foreach ($autoload[$type] as $item){
					$this->$type($item);
				}
			}
		}	
			
		/* autoload database & libraries */
		if (isset($autoload['libraries'])){
			if (in_array('database', $autoload['libraries'])){
				/* autoload database */
				if ( ! $db = CI::$APP->config->item('database')){
					$db['params'] = 'default';
					$db['active_record'] = TRUE;
				}
				$this->database($db['params'], FALSE, $db['active_record']);
				$autoload['libraries'] = array_diff($autoload['libraries'], array('database'));
			}

			/* autoload libraries */
			foreach ($autoload['libraries'] as $library){
				$this->library($library);
			}
		}
		
		/* autoload models */
		if (isset($autoload['model'])){
			foreach ($autoload['model'] as $model => $alias){
				(is_numeric($model)) ? $this->model($alias) : $this->model($model, $alias);
			}
		}
		
		/* autoload module controllers */
		if (isset($autoload['modules'])){
			foreach ($autoload['modules'] as $controller) {
				($controller != $this->_module) AND $this->module($controller);
			}
		}
	}
}

/** load the CI class for Modular Separation **/
(class_exists('CI', FALSE)) OR require dirname(__FILE__).'/Ci.php';