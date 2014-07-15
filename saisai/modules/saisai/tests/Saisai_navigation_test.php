<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('Saisai_test_base.php');

class Saisai_navigation_test extends Saisai_test_base {
	
	public function __construct()
	{
		parent::__construct();
	}

	public function setup()
	{
		parent::setup();
		$this->_login();
	}
	
	public function test_save_navigation()
	{
		$post = $this->_create_nav_item('test', 'Test');
		$page = $this->load_page('saisai/navigation/create', $post);
		$test = $this->_is_success();
		$expected = TRUE;
		$this->run($test, $expected, 'Test for successful save');
	}
	
	public function test_saisai_nav()
	{
		$expected = strip_whitespace('<ul><li class="first last"><a href="'.site_url('test').'">Test</a></li></ul>');
		$test = strip_whitespace(saisai_nav());
		$this->run($test, $expected, 'Test for successful saisai_nav() rendering');
	}
	
	protected function _create_nav_item($location, $label, $parent = 0, $group_id = 1)
	{
		$nav['id'] = NULL;
		$nav['group_id'] = $group_id;
		$nav['location'] = $location; // blank page
		$nav['nav_key'] = $location;
		$nav['label'] = $label;
		$nav['parent_id'] = $parent;
		$nav['precedence'] = NULL;
		$nav['attributes'] = NULL;
		$nav['selected'] = NULL;
		$nav['hidden'] = 'no';
		$nav['published'] = 'yes';
		return $nav;
	}
	

}
