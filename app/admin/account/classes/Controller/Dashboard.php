<?php defined('SYSPATH') or die('No direct script access.');

/**
 * The dashboard controller
 */
class Controller_Dashboard extends Controller_Template {
	public function action_index() {
		$this->_layout->content = View::factory('default');
	}
}
