<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Application Business Layer
 */
class Business_Car_Repair extends Business {
    /**
     * @return array
     */
    public function getAllRepairRecord() {
        return Dao::factory('Car_Repair')->getAll();
    }

    public function getRepairByKeyword($keyword) {
        return Dao::factory('Car_Repair')->getRepairByKeyword($keyword);
    }

    public function getRepairById($repairId) {
        return Dao::factory('Car_Repair')->getRepairById($repairId);
    }

    public function updateById($repairId, $values=array()) {
        $fields = array (
            'repair_id' => 0,
			'company_name' => '',
			'people_name' => '',
			'phone_no' => '',
			'car_type' => '',
			'plate_no' => '',
			'brand' => '',
			'remark' => '',
			'status' => 0,
			'create_time' => time(),
			'update_time' => time(),
		);
		$values = array_intersect_key($values, $fields);
        return Dao::factory('Car_Repair')->updateById($repairId, $values);
    }

	public function create($values = array ()) {
		$fields = array (
			'company_name' => '',
			'people_name' => '',
			'phone_no' => '',
			'car_type' => '',
			'plate_no' => '',
			'brand' => '',
			'remark' => '',
			'status' => 0,
			'create_time' => time(),
			'update_time' => time(),
		);

		$values = array_intersect_key($values, $fields);
		$values = $values + $fields;

		return Dao::factory('Car_Repair')->insert($values);
    }

    public function deleteById($repairId) {
        return Dao::factory('Car_Repair')->deleteById($repairId);
    }
}
