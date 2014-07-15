<?php 
/*
|--------------------------------------------------------------------------
| SAISAI ROUTES
|--------------------------------------------------------------------------
|
| The following are routes used by SAISAI specifically
|
*/
$route[substr(SAISAI_ROUTE, 0, -1)] = "saisai/dashboard";

$module_folder = MODULES_PATH.'/';

// config isn't loaded yet so do it manually'
include(SAISAI_PATH.'config/saisai.php');

// load any public routes for advanced modules
foreach ($config['modules_allowed'] as $module)
{
	$routes_path = $module_folder.$module.'/config/'.$module.'_routes.php';
	
	if (file_exists($routes_path))
	{
		include($routes_path);
	}
}

// to prevent the overhead of this on every request, we do a quick check of the path... USE_SAISAI_ROUTES is defined in saisai_constants
if (USE_SAISAI_ROUTES)
{

	$route[SAISAI_ROUTE.'login|'.SAISAI_ROUTE.'login/:any'] = "saisai/login"; // so we can pass forward param
	
	$module_folder = MODULES_PATH;

	include(SAISAI_PATH.'config/saisai_modules.php');
	@include(APPPATH.'/config/MY_saisai_modules.php');
	
	$modules = array_keys($config['modules']);
	$modules = array_merge($config['modules_allowed'], $modules);

	foreach($modules as $module)
	{
		// check SAISAI folder for controller first... if not there then we use the default module to map to
		if (!file_exists($module_folder.SAISAI_FOLDER.'/controllers/'.$module.EXT)
				AND !file_exists($module_folder.$module.'/controllers/'.$module.'_module'.EXT) 
				)
		{
			$route[SAISAI_ROUTE.$module] = SAISAI_FOLDER.'/module';
			$route[SAISAI_ROUTE.$module.'/(.*)'] = SAISAI_FOLDER.'/module/$1';
		}
		
		// check if controller does exist in SAISAI folder and if so, create the proper ROUTE if it does not equal the SAISAI_FOLDER
		else if (file_exists($module_folder.SAISAI_FOLDER.'/controllers/'.$module.EXT))
		{
			$route[SAISAI_ROUTE.$module] = SAISAI_FOLDER.'/'.$module;
			$route[SAISAI_ROUTE.$module.'/(.*)'] = SAISAI_FOLDER.'/'.$module.'/$1';
		}

		// check module specific folder next
		else if (file_exists($module_folder.$module.'/controllers/'.$module.'_module'.EXT))
		{
			$route[SAISAI_ROUTE.$module] = $module.'/'.$module.'_module';
			$route[SAISAI_ROUTE.$module.'/(.*)'] = $module.'/'.$module.'_module/$1';
		}
	}
	// catch all
	$route[SAISAI_ROUTE.'(:any)'] = SAISAI_FOLDER."/$1";
}


/* End of file saisai_routes.php */
/* Location: ./modules/saisai/config/saisai_routes.php */