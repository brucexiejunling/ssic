<?php 
// array(1) {
//   [0] => array(8) {
//     ["name"] => string(22) "CoffeeScript灏忎功.pdf"
//     ["type"] => string(15) "application/pdf"
//     ["size"] => int(736824)
//     ["key"] => string(6) "preDoc"
//     ["extension"] => string(3) "pdf"
//     ["savepath"] => string(10) "./Uploads/"
//     ["savename"] => string(17) "5246655e8938c.pdf"
//     ["hash"] => string(32) "aeabb5da08a1a6620421ab18e9c29ed2"
//   }
// }
class MaterialModel extends Model {

	private $Material;

	public function _initialize() {
		$this->Material = M('material'); 
	}

	public function getLinkByTeamAndStageId($teamId,$stageId) {
		$condition['teamId'] = $teamId;
		$condition['stageId'] = $stageId;
		$mater = $Material->where($condition)->find(); 
		return $mater;
	}

	public function saveInfo($info, $stageId) {
		// $mater = $this->Material;
		$mater = M('material');
		// $data =
		$data['teamId'] = session('uid');
		$data['stageId'] = $stageId;
		$data['content'] = $info['name'];
		$data['saveName'] = C('UPLOAD_PATH').'/'.$info['savename'];
		$data['type'] = '.pdf';

		$condition['teamId'] = $data['teamId'];
		$condition['satgeId'] = $data['stageId'];

		$check = $mater->where($condition)->find();
		if ($check) {
			$result = $mater->where($condition)->save($data);
		} else {
			$result = $mater->add($data);
		}
		return $result;
	}

	public function getFile( $stageId ) {
		$mater = M('material');
		$condition['teamId'] = session('uid');
		$condition['satgeId'] = $stageId;
		$result = $mater->where($condition)->find();
		return $result;
	}

}


?>