<?php 
class MainAction extends Action {
	
	//set session
	//    uid 
	//    currentStage	
	//    teamStage	
	//    outStage	

	protected $Period;

	public function _initialize() {
		if (session('?ic_isLogin') && session('ic_isLogin') == 'true') {
			$this->Period = D('Period');
			$this->_setStatus();
		} else {
			$this->redirect('Index/index'); 
		}
	}

	private function _setStatus() {

		// if ( session('?currentStage') ) {

			$username = $this->_getUsername();
			session('username',$username);

			$currentStage = $this->_getCurrentStage();
			session('currentStage',$currentStage);
			$cur = session('currentStage');
			$teamStatus = $this->_getTeamStatus();
			//setTeamStatus
			session('teamStatus',$teamStatus);

			//setOutStage
			if($teamStatus == 'out')	{
				$teamOutStage = $this->_getTeamOutStage();
				session('outStage',$teamOutStage);
			}

		// }
	}

	public function _empty($stageName) {
		$this->_gate($stageName);
	}

	public function index() {
		if (session('teamStatus') == 'out') {
			$toGo = session('outStage');
		} else {
			$toGo = $this->_getCurrentStage();
		}
		// $this->_gate($toGo);
		$this->redirect($toGo);
	}


	public function apply() {
		$Team = M('team'); 
		$map['id'] = array('eq',session('uid'));
		$curTeam = $Team->where($map)->find();
		$this->assign('Team',$curTeam);	
		$this->_assignMember($curTeam['leaderId']);
		$this->_assignTeacher();
		$canApply = $this->Period->isNowInPeriod('apply');
		$this->assign('canApply',$canApply);
		$this->_gate('apply');
	}


	public function pre() {

		$ContestInfo = M('contest_info');	

		$Team = M('team'); 
		$condition['id'] = session('uid');
        $platform = $Team->where($condition)->getField('platform');
		$Material = D('Material');
		$this->assign('teamId',session('uid'));
		$stageId = $this->_getOrderByPageName('pre');
		$this->assign('stageId', $stageId);
		$fileInfo = $Material->getFile($stageId);
		$this->assign('platform',$platform);
		$this->assign('file',$fileInfo);
		$this->_gate('pre');

	}

	protected function _assignMember($leaderId) {
		$Member = M('member');
		$map['teamId'] = array('eq',session('uid'));
		$map['type'] = array('eq','member');
		$members = $Member->where($map)->select();
		$map2['teamId'] = array('eq',session('uid'));
		$map2['type'] = array('eq','leader');
		$leader = $Member->where($map2)->find();
		$this->assign('leader', $leader);
		$this->assign('Members', $members);
		return;
	}

	protected function _assignTeacher() {
		$Advisor = M('advisor');
		$condition['teamId'] = session('uid');
		$Advisors = $Advisor->where($condition)->select();
		$this->assign('Advisors',$Advisors);
	}

	protected function _gate($pageName) {
		$ContestInfo = M('contest_info');	
        $announcement = $ContestInfo->where('id=1')->getField('announction');

		$accessable = $this->_judgeStageAccessable($pageName);
		$isLatestStage = $this->_judgeIsLatest($pageName);
		$teamStatus = session('teamStatus'); 
		$stageMapping = $this->Period->mapping;
		$orderMapping = $this->Period->order;


		$latestStage = $this->_getLatestPage();
		$laterPages = $this->Period->getLaterPageName($latestStage);

		$latestStageOrder = $this->_getLatestPageOrder();

		$this->assign('announcement', $announcement);
		$this->assign('latestPageOrder',$latestStageOrder);
		$this->assign('orderList',$orderMapping);
		$this->assign('isLatestStage',$isLatestStage);
		$this->assign('teamStatus',$teamStatus);
		$this->assign('activePage',$pageName);
		$this->assign('stageList',$stageMapping);
		$this->assign('laterPages',$laterPages);

		// echo 'username';
		// dump(session('username'));
		// echo 'currentStage';
		// dump(session('currentStage'));
		// echo 'teamStatus';
		// dump(session('teamStatus'));
		// echo 'outStage';
		// dump(session('outStage'));
		// echo 'accessable';
		// dump($accessable);
		// echo 'display';
		// dump($pageName);

		try {
			$msg = $this->display($pageName);
		} catch (Exception $e) {
			$this->Index();
		};
	}

	protected function _judgeIsLatest($pageName) {
		if (session('teamStatus') == out ){
			$latestStage = session('outStage');	
		} else {
			$latestStage = $this->_getCurrentStage();
		}
		return ($pageName == $latestStage);
	}


	protected function _getCurrentStage() {
		$Period = D('Period');
		$result = $Period->getCurrentStage();
		return $result;
	}

	protected function _getUsername() {
		$Team = M('Team');
		$condition['id'] = session('uid');
		$username = $Team->where($condition)->getField('username');
		return $username;
	}

	protected function _getTeamStatus() {
		$Team = M('Team');
		$condition['id'] = session('uid');
		$status = $Team->where($condition)->getField('status');
		return $status;
	}

	protected function _getTeamOutStage() {
		$Team = M('Team');
		$condition['id'] = session('uid');
		$stageName = $Team->where($condition)->getField('outStage');
		return $stageName;
	}

	protected function _judgeStageAccessable($stageName) {
		$Period = D('Period');
		$currentStage = $Period->getCurrentStage();
		$outStage = session('outStage');
		if (session('teamStatus') == 'out') {
			$result = $Period->isNotGreater($stageName,$outStage);
		} else {
			$result = $Period->isNotGreater($stageName,$currentStage); 
		}
		if (!$result) {
			$this->redirect('index');
		}

		return $result;

	}

	protected function _getLatestPage() {
		if (session('teamStatus') == 'out') {
			$result = session('outStage');
		} else {
			$result = $this->_getCurrentStage();
		}	
		return $result;
	}

	protected function _getLatestPageOrder() {
		$latestPage = $this->_getLatestPage();
		$latestPageOrder = $this->_getOrderByPageName($latestPage);
		return $latestPageOrder;
	}

	protected function _getOrderByPageName($pageName) {
		$Period = D("Period");
		return $Period->order[$pageName];
	}

	public function deleteTeam() {
		$Member = M('member');
		$Team = M('team');
		$Advisor = M('advisor');
		$teamId = session("uid");
		$map['id'] = array('eq',$teamId);	
		$results['team'] = $Team->where($map)->delete();
		$map2['teamId'] = array('eq',$teamId);	
		$results['member'] = $Member->where($map2)->delete();
		$results['advisor']	= $Advisor->where($map2)->delete();
		foreach ($result as $key=>$value) {
			if ($value == false) {
				$this->error($key);
			}
		}
		$this->success("正在退出",'logout');
	}

	public function logout() {
		session(null);
		$this->redirect('Index/index');
	}

	// public function dealWithUpload() {
	// 	D()
	// 	dump($preDoc);	
	// }
	public function dealWithPlatform() {
		$team = M('Team');	
		if ($this->isPost()) {
			$platform = I('post.platform');
			$condition['id'] = session('uid');
			$data['platform'] = $platform;
	        $result = $team->where($condition)->setField($data);
	        if ($result) {
	        	$this->ajaxReturn(array(
					'msg'=>'ok'
				));
	        } else {
	        	$this->ajaxReturn(array(
					'msg'=>'no'
				));
	        }
	       	

		}
	}

	public function dealWithUpload(){
		import('ORG.Net.UploadFile');
        $upload = new UploadFile();// 实例化上传类
        $upload->maxSize  = 8388608;// 设置附件上传大小
        $upload->allowExts  = array('pdf');// 设置附件上传类型
        $upload->savePath =  './Uploads/';// 设置附件上传目录
        if(!$upload->upload()) {// 上传错误提示错误信息
        	$this->error($upload->getErrorMsg());
        }else{// 上传成功 获取上传文件信息
        	$info =  $upload->getUploadFileInfo();
        }

        $stageId = $this->_getOrderByPageName('pre');
        $Meterial = D('Material');
        $result = $Meterial->saveInfo($info[0],$stageId);
        if ($result) {
			$this->success('上传成功','pre');
		} else {
			$this->error('上传失败');
		}
    }

}

 ?>