<?php 
class SetdataAction extends Action {

	public function _initialize() {
		echo '_'
		tag('keke');
	}

	public function setStage() {
		$Stage = M('Stage');
		$stage1 = $Stage->find(1);
		dump($stage1['name']);
		$flowStage = $Stage->where('id=10')->getField('startTime');
		// $flowStage = $Stage->where("type=flow AND");
		dump($flowStage);
		dump($flowStage[startTime]);

	}

}
 ?>