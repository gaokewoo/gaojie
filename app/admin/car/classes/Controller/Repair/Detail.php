<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Repair_Detail extends Controller_Template {
    public function action_index() {
        Controller::redirect(MODULEDIR . '/repair_detail/list');
    }

    public function action_list() {
        $this->_autoRender = false;
        $errors = array();
        $repairDetails =  null;
        $layout = View::factory('layouts/layer');
        $layout->content = View::factory('repair/detail/list')
             ->bind('repairDetails', $repairDetails)
             ->bind('repairId', $repairId)
             ->bind('errors', $errors);

        $repairId = Arr::get($_GET, 'repairId', 0);
        if (!Valid::not_empty($repairId)) {
            $errors[] = 'repairId为空！';
        }
        if ($errors) {
            return $this->response->body($layout->render());
        }
        $repairDetails = BLL::Car_Repair_Detail()->getRepairDetailByRepairId($repairId)->getObject('Model_Repair_Detail');
        $this->response->body($layout->render());
    }

	public function action_save() {
		$this->_autoRender = false;

		$errors = array();
        $repairId = Arr::get($_GET, 'repairId', 0);
        if (!Valid::not_empty($repairId)) {
            $errors[] = 'repairId为空！';
        }

        $result = BLL::Car_Repair_Detail()->deleteByRepairId($repairId)->getArray();
        if (!Valid::not_empty($result)) {
            $errors[] = '删除repair_detail表失败！';
        }
        if ($errors) {
            Logger_Client::behaviorLog(implode("\t", $errors));
            return Misc::jsonError($errors);
        }

        $repairDetailInfo = json_decode(file_get_contents("php://input"), true);
        foreach($repairDetailInfo as $row){
            $repairDate    = $row['repairDate'];
            $repairProject = $row['repairProject'];
            $partProject   = $row['partProject'];
            $price         = intval(doubleval($row['price']) * 100);
            $partNum       = intval($row['partNum']);
            $workHour      = intval($row['workHour']);
            $supplier      = $row['supplier'];
            $warrantyPeriod= intval($row['warrantyPeriod']);
            $gearOilStatus = intval($row['gearOilStatus']);
            $thisServiceMileage = intval($row['thisServiceMileage']);
            $nextServiceMileage = intval($row['nextServiceMileage']);
            $payedStatus   = intval($row['payedStatus']);
            $payed         = intval(doubleval($row['payed']) * 100);
            $sumMoney      = intval(doubleval($row['sumMoney']) * 100);
            $remark        = $row['remark'];
		    
            if(!Valid::not_empty($repairProject)
                && !Valid::not_empty($partProject)
                && $price<=0
                && $workHour<=0){
                continue;
            }

            // 信息入库
            $values = array(
                'repair_date'    => $repairDate,
                'repair_project' => $repairProject,
                'part_project'   => $partProject,
                'price'          => $price,
                'part_num'       => $partNum,
                'work_hour'      => $workHour,
                'repair_id'      => $repairId,
                'supplier'       => $supplier,
                'warranty_period'      => $warrantyPeriod,
                'gear_oil_status'      => $gearOilStatus,
                'this_service_mileage' => $thisServiceMileage,
                'next_service_mileage' => $nextServiceMileage,
                'payed_status'   => $payedStatus,
                'payed'          => $payed,
                'sum_money'      => $sumMoney,
                'remark'         => $remark,
            );
            try {

                $result = BLL::Car_Repair_Detail()->create($values)->getArray();
                if (!Valid::not_empty($result)) {
                    $errors[] = '插入repair_detail表失败！';
                }
            } catch(Exception $e) {
                $errors[] = $e->getMessage();
            }
            if ($errors) {
                Logger_Client::behaviorLog(implode("\t", $errors));
                return Misc::jsonError($errors);
            }
        }
        Logger_Client::behaviorLog('保存维修详情'.$repairId.' 成功');
		return Misc::jsonSuccess('保存维修详情成功');
	}
}
