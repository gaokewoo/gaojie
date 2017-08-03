<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Application Business Layer
 */
class Business_Car_Repair_Detail extends Business {
    /**
     * @return array
     */
    public function getRepairDetailByRepairId($repairId) {
        return Dao::factory('Car_Repair_Detail')->selectByRepairId($repairId);
    }

	public function create($values = array ()) {
		$fields = array (
            'repair_date'    => date('Y-m-d',time()),
			'repair_project' => '',
			'part_project'   => '',
			'price'          => 0,
            'part_num'       => 0,
			'work_hour'      => 0,
			'status'         => 0,
			'repair_id'      => 0,
            'supplier'       => '',
            'warranty_period'=> 0,
            'gear_oil_status'=> 0,
            'this_service_mileage'=>-1,
            'next_service_mileage'=>-1,
            'payed_status'   => 0,
            'payed'          => 0,
            'sum_money'      => 0,
            'remark'         => '',
			'create_time'    => time(),
			'update_time'    => time(),
		);

		$values = array_intersect_key($values, $fields);
		$values = $values + $fields;

		return Dao::factory('Car_Repair_Detail')->insert($values);
    }

    public function deleteByRepairId($repairId) {
        return Dao::factory('Car_Repair_Detail')->deleteByRepairId($repairId);
    }
}
