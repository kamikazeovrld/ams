<?php 
/*
|--------------------------------------------------------------------------
| MY Custom Modules
|--------------------------------------------------------------------------
|
| Specifies the module controller (key) and the name (value) for saisai
*/


/*********************** EXAMPLE ***********************************

$config['modules']['quotes'] = array(
	'preview_path' => 'about/what-they-say',
);

$config['modules']['projects'] = array(
	'preview_path' => 'showcase/project/{slug}',
	'sanitize_images' => FALSE // to prevent false positives with xss_clean image sanitation
);

*********************** /EXAMPLE ***********************************/



/*********************** OVERWRITES ************************************/

$config['module_overwrites']['categories']['hidden'] = TRUE; // change to FALSE if you want to use the generic categories module
$config['module_overwrites']['tags']['hidden'] = TRUE; // change to FALSE if you want to use the generic tags module

/*********************** /OVERWRITES ************************************/

$config['modules']['advertisers'] = array(
	'preview_path' => '', // put in the preview path on the site e.g products/{slug}
	'model_location' => '', // put in the advanced module name here
);

$config['modules']['ads'] = array(
	'preview_path' => 'ads/{id}', // put in the preview path on the site e.g products/{slug}
    'display_field' => 'name',
    'sanitize_input' => array('template','php')
);

$config['modules']['polls'] = array(
	'preview_path' => '', // put in the preview path on the site e.g products/{slug}
	'model_location' => '', // put in the advanced module name here
);

$config['modules']['textmatchs'] = array(
	'preview_path' => '', // put in the preview path on the site e.g products/{slug}
	'model_location' => '', // put in the advanced module name here
);

$config['modules']['clicktovisits'] = array(
	'preview_path' => '', // put in the preview path on the site e.g products/{slug}
	'model_location' => '', // put in the advanced module name here
);
