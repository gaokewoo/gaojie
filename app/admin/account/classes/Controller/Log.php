<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Log Controller
 */
class Controller_Log extends Controller_Template {

	public function action_index() {
		Controller::redirect('log/behavior');
	}

	public function action_crash() {
		$page = Arr::get($_GET, 'page', 1);
		$number  = Arr::get($_GET, 'number', 20);
		$keyword = htmlspecialchars(Arr::get($_GET, 'keyword', ''));

		$crashLogs = array();
		$count = 0;
		$offset = ($page - 1) * $number;
		if (Valid::not_empty($keyword)) {
			$count = BLL::Log_Crash()->getCountCrashLogsByKeyword($keyword)->getArray();
			$crashLogs = BLL::Log_Crash()->getCrashLogsByKeyword($keyword, $offset, $number)->getObject('Model_Log_Crash');
		} else {
			$count = BLL::Log_Crash()->getCountCrashLogs()->getArray();
			$crashLogs = BLL::Log_Crash()->getCrashLogs($offset, $number)->getObject('Model_Log_Crash');
		}

		$pagination = Pagination::factory($count, $number)->execute();

		$this->_layout->content = View::factory('log/crash')
			->set('crashLogs', $crashLogs)
			->set('pagination', $pagination)
			->set('number', $number)
			->set('keyword', $keyword);
	}

    /**
     * 行为日志
     */
    public function action_behavior() {
    	$page = Arr::get($_GET, 'page', 1);
		$number  = Arr::get($_GET, 'number', 20);
		$keyword = htmlspecialchars(Arr::get($_GET, 'keyword', ''));

		$behaviorLogs = array();
		$count = 0;
		$offset = ($page - 1) * $number;
		if (Valid::not_empty($keyword)) {
			$count = BLL::Log_Behavior()->getCountBehaviorLogsByKeyword($keyword)->getArray();
			$behaviorLogs = BLL::Log_Behavior()->getBehaviorLogsByKeyword($keyword, $offset, $number)->getObject('Model_Log_Behavior');
		} else {
			$count = BLL::Log_Behavior()->getCountBehaviorLogs()->getArray();
			$behaviorLogs = BLL::Log_Behavior()->getBehaviorLogs($offset, $number)->getObject('Model_Log_Behavior');
		}

		$pagination = Pagination::factory($count, $number)->execute();

		$this->_layout->content = View::factory('log/behavior')
			->set('behaviorLogs', $behaviorLogs)
			->set('pagination', $pagination)
			->set('number', $number)
			->set('keyword', $keyword);
    }
}
