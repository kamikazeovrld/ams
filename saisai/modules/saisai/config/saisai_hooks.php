<?php
/*
|--------------------------------------------------------------------------
| SAISAI HOOKS
|--------------------------------------------------------------------------
|
| The following are hooks used by SAISAI specifically. This file is included
| in the saisai/application/config/hooks.php file
|
*/

$hook['pre_controller'][] = array(
								'class'    => 'Saisai_hooks',
								'function' => 'pre_controller',
								'filename' => 'Saisai_hooks.php',
								'filepath' => 'hooks',
								'params'   => array(),
								'module' => SAISAI_FOLDER,
								);

$hook['post_controller_constructor'][] = array(
								'class'    => 'Saisai_hooks',
								'function' => 'dev_password',
								'filename' => 'Saisai_hooks.php',
								'filepath' => 'hooks',
								'params'   => array(),
								'module' => SAISAI_FOLDER,
								);

$hook['post_controller_constructor'][] = array(
								'class'    => 'Saisai_hooks',
								'function' => 'offline',
								'filename' => 'Saisai_hooks.php',
								'filepath' => 'hooks',
								'params'   => array(),
								'module' => SAISAI_FOLDER,
								);

$hook['post_controller_constructor'][] = array(
								'class'    => 'Saisai_hooks',
								'function' => 'redirects',
								'filename' => 'Saisai_hooks.php',
								'filepath' => 'hooks',
								'params'   => array(),
								'module'   => SAISAI_FOLDER,
								);

$hook['post_controller'][] = array(
								'class'    => 'Saisai_hooks',
								'function' => 'post_controller',
								'filename' => 'Saisai_hooks.php',
								'filepath' => 'hooks',
								'params'   => array(),
								'module' => SAISAI_FOLDER,
								);

/* End of file saisai_hooks.php */
/* Location: ./modules/saisai/config/saisai_hooks.php */