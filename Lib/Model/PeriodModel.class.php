<?php 

//各阶段(stage)对应在数据库时间段表(period)

//apply : 
//  from : contest->startTime
//  to : pre_upload->startTime
//  
//pre : 
//  from : pre_upload->startTime
//  to : first_upload->startTime
//  
//first : 
//  from : first_upload->startTime
//  to : second_upload->startTime
//  
//second : 
//  from : second_upload->startTime
//  to : second_upload->startTime
//  
//revive: 
//  from : revive_upload->startTime
//  to : final_upload->startTime
//
//final: 
//  from : final_upload->startTime
//  to : contest->endTime



class PeriodModel extends Model {

	protected $Period;

	public $mapping; 

	public $order;

	public function _initialize() {
		$this->Period = M('period');
		$this->mapping = array(
			'apply' => '报名',
			'pre' => '初审',
			'first' => '初赛',
			'second' => '复赛',
			'revive' => '复活赛',
			'final' => '决赛',
			);

		$this->order = array(
			'apply' => 1,
			'pre' => 2,
			'first' => 3,
			'second' => 4,
			'revive' => 5,
			'final' => 6,
			);

		date_default_timezone_set('Asia/Shanghai');
	}


	public function getCurrentStage() {

		$stageArray = $this->getStageArray();
		$stageName = $this->_getCurrentStageCompareWithArray($stageArray);

		return $stageName;

	}

	public function getCurrentOrder() {
		$name = $this->getCurrentStage();
		return $this->order[$name];
	}

	public function getLaterPageName($latestStage) {
		$laterPagesName = [];
		$latestStageOrder = $this->order[$latestStage];
		foreach ($this->order as $name => $order) {
			if ($order > $latestStageOrder) {
				$laterPagesName[$order] = $name;
			}
		}
		return $laterPagesName;
	}

	public function getStageArray() {
		$array = [];
		$array['apply'] = $this->_setStageToArray('contest','pre_upload');
		$array['pre'] = $this->_setStageToArray('pre_upload','first_upload');
		$array['first'] = $this->_setStageToArray('first_upload','second_upload');
		$array['second'] = $this->_setStageToArray('second_upload','revive_upload');
		$array['revive'] = $this->_setStageToArray('revive_upload','final_upload');
		$array['final'] = $this->_setStageToArray('final_upload','contest','startTime','endTime');
		return $array;
	}


	public function getTimeByStageName($stageName) {
		$stageArray = $this->getStageArray();
		return $stageArray[$stageName];
	}


	public function getTimeByPeriodName($periodName,$startOrEndTime='startTime') {
		$Period = $this->Period;
		$condition['name'] = $periodName;
		$time = $Period->where($condition)->getField($startOrEndTime);
		return $time;
	}

	public function isNotGreater($name1,$name2) {
		$first = $this->order[$name1];
		$second = $this->order[$name2];
		return $first <= $second;
	}

	public function isNowInPeriod($periodName) {
		$curTime = time();
		$startTime = $this->getTimeByPeriodName($periodName,'startTime');
		$endTime = $this->getTimeByPeriodName($periodName,'endTime');
		$start = strtotime($startTime);
		$end = strtotime($endTime);
		return ($start <= $curTime && $end > $curTime);
	}



	//protected
	protected function _setStageToArray($from,$to,$fromStartOrEnd='startTime',$toStartOrEnd='startTime') {
		$array = [];
		$array['start'] = $this->getTimeByPeriodName($from,$fromStartOrEnd);
		$array['end'] = $this->getTimeByPeriodName($to,$toStartOrEnd);
		return $array;
	}
	
	protected function _getCurrentStageCompareWithArray($stageArray) {
		$curTime = time();
		$array = [];
		foreach ($stageArray as $stage => $timeArray) {
			$start = strtotime($timeArray['start']);
			$end = strtotime($timeArray['end']);
			if ( $start<=$curTime && $end > $curTime ) {
				return $stage;
			}
		}
	}	

}
?>