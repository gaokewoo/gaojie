<?php defined('SYSPATH') or die('No direct script access.');
/**
 */
class Controller_Repair extends Controller_Template {
	public function action_index() {
		Controller::redirect(MODULEDIR . '/repair/list');
    }

	public function action_list() {
        $keyword = htmlspecialchars(Arr::get($_GET, 'keyword', ''));

		if (Valid::not_empty($keyword)) {
	        $repairs = BLL::Car_Repair()->getRepairByKeyword($keyword)->getObject('Model_Repair');
		} else {
	        $repairs = BLL::Car_Repair()->getAllRepairRecord()->getObject('Model_Repair');
		}
		
		$this->_layout->content = View::factory('repair/list')
		    ->set('repairs', $repairs)
			->set('keyword', $keyword);
	}

    public function action_add() {
		$this->_layout->content = View::factory('repair/add');
    }

    public function action_edit(){
		$errors = array();
        $repairId = Arr::get($_GET, 'repairId', 0);
        if ($repairId == 0) {
             throw new Business_Exception('repairId 为空');
        }
	    $repair = BLL::Car_Repair()->getRepairById($repairId)->getObject('Model_Repair')->current();
		$this->_layout->content = View::factory('repair/edit')
		    ->set('repairId', $repairId)
		    ->set('repair', $repair);
    }

    public function action_modify(){
		$this->_autoRender = false;
        
        $repairId    = Arr::get($_GET, 'repairId', 0);
		$companyName = Arr::get($_POST, 'company_name', '');
		$peopleName  = Arr::get($_POST, 'people_name', '');
		$phoneNo     = Arr::get($_POST, 'phone_no', '');
		$carType     = Arr::get($_POST, 'car_type', '');
		$plateNo     = Arr::get($_POST, 'plate_no', '');
		$status      = Arr::get($_POST, 'status', 0);

		// 数据合法性检测
		$errors = array();
        if ($repairId == 0) {
			$errors[] = 'repairId不能为0！';
        }
		if (!Valid::not_empty($peopleName)) {
			$errors[] = '姓名不能为空！';
		}
		if (!Valid::not_empty($plateNo)) {
			$errors[] = '车牌不能为空！';
		} 
		if ($errors) {
			return Misc::jsonError($errors);
		}

		// 信息入库
        $values = array(
            'repair_id'    => $repairId,
			'company_name' => $companyName,
			'people_name'  => $peopleName,
			'phone_no'     => $phoneNo,
			'car_type'     => $carType,
			'plate_no'     => $plateNo,
			'status'       => $status
		);
		try {
			$result = BLL::Car_Repair()->updateById($repairId, $values)->getArray();
			if (!Valid::not_empty($result)) {
				$errors[] = '更新repair表失败！';
			}
		} catch(Exception $e) {
			$errors[] = $e->getMessage();
		}
		if ($errors) {
			Logger_Client::behaviorLog(implode("\t", $errors));
			return Misc::jsonError($errors);
		}

		Logger_Client::behaviorLog('更新记录 '.$repairId.' 成功');
		return Misc::jsonSuccess('更新记录成功', URL::site('repair/list'));
    }

    public function action_delete() {
		$this->_autoRender = false;
		$errors = array();
        $repairId = Arr::get($_GET, 'repairId', 0);
        if ($repairId == 0) {
             throw new Business_Exception('repairId 为空');
        }

        $result = BLL::Car_Repair()->deleteById($repairId)->getArray();
        if (!Valid::not_empty($result)) {
             throw new Business_Exception('插入repair表失败！');
        }

		Logger_Client::behaviorLog('删除记录 '.$repairId.' 成功！');
		return Misc::jsonSuccess('删除记录成功！', URL::site('repair/list'));
    }

	public function action_save() {
		$this->_autoRender = false;

		$companyName = Arr::get($_POST, 'company_name', '');
		$peopleName = Arr::get($_POST, 'people_name', '');
		$phoneNo = Arr::get($_POST, 'phone_no', '');
		$carType = Arr::get($_POST, 'car_type', '');
		$plateNo = Arr::get($_POST, 'plate_no', '');
		$status = Arr::get($_POST, 'status', 0);

		// 数据合法性检测
		$errors = array();
		if (!Valid::not_empty($peopleName)) {
			$errors[] = '姓名不能为空！';
		}
		if (!Valid::not_empty($plateNo)) {
			$errors[] = '车牌不能为空！';
		} 
		if ($errors) {
			return Misc::jsonError($errors);
		}

		// 信息入库
		$values = array(
			'company_name' => $companyName,
			'people_name' => $peopleName,
			'phone_no' => $phoneNo,
			'car_type' => $carType,
			'plate_no' => $plateNo,
			'status' => $status
		);
		try {
			$result = BLL::Car_Repair()->create($values)->getArray();
			if (!Valid::not_empty($result)) {
				$errors[] = '插入repair表失败！';
			}
		} catch(Exception $e) {
			$errors[] = $e->getMessage();
		}
		if ($errors) {
			Logger_Client::behaviorLog(implode("\t", $errors));
			return Misc::jsonError($errors);
		}

		Logger_Client::behaviorLog('新增记录 '.$plateNo.' 成功');
		return Misc::jsonSuccess('新增记录成功', URL::site('repair/list'));
	}
}
