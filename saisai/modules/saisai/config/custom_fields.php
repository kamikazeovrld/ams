<?php

// datetime field
$fields['datetime'] = array(
	'css_class' => 'datepicker',
	'js_function' => 'saisai.fields.datetime_field',
	// 'js_params' => array('format' => 'mm-dd-yyyy'),
	'represents' => 'datetime|timestamp',
);

// date field
$fields['date'] = array(
	'css_class' => 'datepicker',
	'js_function' => 'saisai.fields.datetime_field',
);

// multi field
$fields['multi'] = array(
	'class'		=> array(SAISAI_FOLDER => 'Saisai_custom_fields'),
	'function'	=> 'multi',
	// 'js'		=> array(
	// 					SAISAI_FOLDER => array(
	// 						'jquery/plugins/jquery.selso',
	// 						'jquery/plugins/jquery.disable.text.select.pack',
	// 						'jquery/plugins/jquery.supercomboselect',
	// 					)
	// ),
	'js_function' => 'saisai.fields.multi_field',
	//'css' => array(SAISAI_FOLDER => 'jquery.supercomboselect'),
	'represents' => 'array',
);	

// multi field
$fields['asset'] = array(
	'class'		=> array(SAISAI_FOLDER => 'Saisai_custom_fields'),
	'function'	=> 'asset',
	'filepath'	=> '',
	// 'js'		=> array(
	// 					SAISAI_FOLDER => array(
	// 						'jquery/plugins/jqModal',
	// 					)
	// ),
	'js_function' => 'saisai.fields.asset_field',
	'represents' => array('name' => '.*image\]?$|.*img\]?$'),
);

// wysiwyg field
$fields['wysiwyg'] = array(
	'class'		=> array(SAISAI_FOLDER => 'Saisai_custom_fields'),
	'function'	=> 'wysiwyg',
	'filepath'	=> '',
	'js'		=> array(
						SAISAI_FOLDER => array(
							'editors/markitup/jquery.markitup',
							'editors/markitup/jquery.markitup.set',
							'editors/ckeditor/ckeditor.js',
							'editors/ckeditor/config.js',
						)
	),
	//'css' => array(SAISAI_FOLDER => 'markitup'),
	'js_function' => 'saisai.fields.wysiwyg_field',
	'represents' => array('text', 'textarea', 'longtext', 'mediumtext'),
);

// file field
$fields['file'] = array(
	'class'		=> array(SAISAI_FOLDER => 'Saisai_custom_fields'),
	'function'	=> 'file',
	'filepath'	=> '',
	// 'js'		=> array(
	// 					SAISAI_FOLDER => array(
	// 						'jquery/plugins/jquery.MultiFile',
	// 					)
	// ),
	'js_function' => 'saisai.fields.file_upload_field',
	'represents' => 'blob',
	
);

// inline edit filed
$fields['inline_edit'] = array(
	'class'		=> array(SAISAI_FOLDER => 'Saisai_custom_fields'),
	'function'	=> 'inline_edit',
	'js_function' => 'saisai.fields.inline_edit_field',
	'represents' => array('select'),
);

// linked field
$fields['linked'] = array(
	'class'		=> array(SAISAI_FOLDER => 'Saisai_custom_fields'),
	'function'	=> 'linked',
	'filepath'	=> '',
	// 'js'		=> array(
	// 	SAISAI_FOLDER => array(
	// 		'saisai/linked_field_formatters',
	// 	)
	// ),
	'js_function' => 'saisai.fields.linked_field',

);

// template field
$fields['template'] = array(
	'class'		=> array(SAISAI_FOLDER => 'Saisai_custom_fields'),
	'function'	=> 'template',
	'filepath'	=> '',
	// 'js'		=> array(
	// 					SAISAI_FOLDER =>
	// 						'jquery/plugins/jquery.repeatable',
	// 						),
	'js_function' => 'saisai.fields.template_field',
	'js_exec_order' => 0, // must be set to 0 so that the node clone will get raw nodes before other js is executed
);

// number field
$fields['number'] = array(
	//'js'		=> array(SAISAI_FOLDER => 'jquery/plugins/jquery.numeric'),
	'js_function' => 'saisai.fields.number_field',
	'represents' => array('int', 'smallint', 'mediumint', 'bigint'),
);

// currency field
$fields['currency'] = array(
	'class'		=> array(SAISAI_FOLDER => 'Saisai_custom_fields'),
	'function'	=> 'currency',
	'filepath'	=> '',
	'js'		=> array(SAISAI_FOLDER => 'jquery/plugins/jquery.autoNumeric'),
	'js_function' => 'saisai.fields.currency_field',
	'represents' => array('name' => 'price')
);

// state field
$fields['state'] = array(
	'class'		=> array(SAISAI_FOLDER => 'Saisai_custom_fields'),
	'function'	=> 'state',
	'filepath'	=> '',
	'represents' => array('name' => 'state'),
	
);

// slug field
$fields['slug'] = array(
	'class'		=> array(SAISAI_FOLDER => 'Saisai_custom_fields'),
	'function'	=> 'slug',
	'filepath'	=> '',
	// 'js'		=> array(
	// 	SAISAI_FOLDER => array(
	// 		'saisai/linked_field_formatters',
	// 	)
	// ),
	'js_function' => 'saisai.fields.linked_field',
	'represents' => array('name' => 'slug|permalink'),
);

// list items
$fields['list_items'] = array(
	'class'		=> array(SAISAI_FOLDER => 'Saisai_custom_fields'),
	'function'	=> 'list_items',
	'filepath'	=> '',
);

// url field
$fields['url'] = array(
	'class'		=> array(SAISAI_FOLDER => 'Saisai_custom_fields'),
	'function'	=> 'url',
	'filepath'	=> '',
	// 'js'		=> array(
	// 					SAISAI_FOLDER => array(
	// 						'jquery/plugins/jqModal',
	// 					)
	// ),
	'js_function' => 'saisai.fields.url_field',
	'represents' => array('name' => 'url|link'),
);

// language field
$fields['language'] = array(
	'class'		=> array(SAISAI_FOLDER => 'Saisai_custom_fields'),
	'function'	=> 'language',
	'filepath'	=> '',
	'represents' => array('name' => 'language'),
);

// keyval field
$fields['keyval'] = array(
	'class'		=> array(SAISAI_FOLDER => 'Saisai_custom_fields'),
	'function'	=> 'keyval',
	'filepath'	=> '',
);

// block field
$fields['block'] = array(
	'class'		=> array(SAISAI_FOLDER => 'Saisai_custom_fields'),
	'function'	=> 'block',
	'filepath'	=> '',
	'js_function' => 'saisai.fields.block',

);

/* End of file custom_fields.php */
/* Location: ./modules/saisai/config/custom_fields.php */