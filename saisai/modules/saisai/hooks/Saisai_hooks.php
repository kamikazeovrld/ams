<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * SAISAI CMS
 * http://www.getsaisaicms.com
 *
 * An open source application Content Management System based on the 
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
 * 	Hooks for SAISAI
 *
 * @package		SAISAI CMS
 * @subpackage	Libraries
 * @category	Libraries
 * @author		David McReynolds @ Daylight Studio
 * @link		http://docs.getsaisaicms.com
 */

class Saisai_hooks
{
	
	public function __construct()
	{
	}
		
	// this hook allows us to route the the saisai controller if the method
	// on a controller doesn't exist... not just the controller itself'
	public function pre_controller()
	{
		// if called from same Wordpress, the the global scope will not work
		global $method, $class, $RTR;
		$class_methods = get_class_methods($class);
		// for pages without methods defined
		if ((isset($class_methods) AND !in_array($method, $class_methods) AND !in_array('_remap', $class_methods))  AND !empty($RTR->default_controller))
		{
			$saisai_path = explode('/', $RTR->routes['404_override']);
			if (!empty($saisai_path[1]))
			{
				require_once(SAISAI_PATH.'/controllers/'.$saisai_path[1].'.php');
				$class = $saisai_path[1];
			}
		}
	}

	// this hook performs redirects before trying to find the page (vs. passive redirects which will only happen if no page is found by SAISAI)
	public function redirects()
	{
		$CI =& get_instance();
		$CI->saisai->redirects->enforce_host();
		$CI->saisai->redirects->ssl();
		$CI->saisai->redirects->non_ssl();

		if (!USE_SAISAI_ROUTES)
		{
			$CI->saisai->redirects->execute(FALSE, FALSE);
		}
	}

	// this hook allows us to setup a development password for the site
	public function dev_password()
	{
		if (!USE_SAISAI_ROUTES)
		{
			$CI =& get_instance();
			if ($CI->saisai->config('dev_password') AND !$CI->saisai->auth->is_logged_in() AND (!preg_match('#^'.saisai_uri('login').'#', uri_path(FALSE))))
			{
				if (isset($_POST['saisai_dev_password']) AND $_POST['saisai_dev_password'] == md5($CI->saisai->config('dev_password')))
				{
					return;
				}

				$CI->load->library('session');
				if (!$CI->session->userdata('dev_password'))
				{
					//redirect('saisai/login/dev');
                    redirect(SAISAI_ROUTE.'login/dev'); //to respect your MY_Saisai $config['saisai_path']
				}
			}
		}
	}
	
	// this hook allows us to display an offline page
	public function offline()
	{
		if (!USE_SAISAI_ROUTES)
		{
			$CI =& get_instance();
			if ($CI->saisai->config('offline') AND !$CI->saisai->auth->is_logged_in() AND (!preg_match('#^'.saisai_uri('login').'#', uri_path(FALSE))))
			{
				echo $CI->saisai->pages->render('offline', array(), array(), TRUE);
				exit();
			}
		}
	}

	// this hook allows us to enable profiler
	public function post_controller()
	{
		$CI =& get_instance();
		$CI->output->enable_profiler($CI->config->item('enable_profiler'));
	}
}

/* End of file ClassName.php */
/* Location: ./application/hooks/Saisai_hooks.php */