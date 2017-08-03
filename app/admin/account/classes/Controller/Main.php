<?php defined('SYSPATH') or die('No direct script access.');

/**
 * The main controller
 */
class Controller_Main extends Controller_Template {

	protected $_layout = 'layouts/main';

	public function action_index() {
        $privileges = array();
		$this->_layout->content = View::factory('main/index')
			->bind('privileges', $privileges);
	}
}
