<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="utf-8">
 	<title>
		<?php 
			if (!empty($is_blog)) :;
				echo $CI->saisai_blog->page_title($page_title, ' : ', 'right');
			else:
				echo saisai_var('page_title', '');
			endif;
		?>
	</title>

	<meta name="keywords" content="<?php echo saisai_var('meta_keywords')?>">
	<meta name="description" content="<?php echo saisai_var('meta_description')?>">

	<link href='http://fonts.googleapis.com/css?family=Raleway:400,700' rel='stylesheet' type='text/css'>
	<?php
		echo css('main').css($css);

		if (!empty($is_blog)):
			echo $CI->saisai_blog->header();
		endif;
	?>

</head>
<body>
	<div class="page">
		<div class="wrapper">
			<header class="page_header">
				<div class="logo"><object type="image/svg+xml" width="160" height="145" data="<?php echo img_path('_template_icons.svg#saisai') ?>"></object></div>
				<h1><?php echo saisai_var('heading')?></h1>
				<h1>this is the header block</h1>
			</header>