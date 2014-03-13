<?php
class ChangeInfoAction extends Action {

	public function _initialize() {
		if (!(session('?ic_isLogin') && session('ic_isLogin') == 'true')) {
			$this->redirect('Index/index'); 
		}
		$canAccess = D('Period')->isNowInPeriod('apply');	
		if (!$canAccess) {
			$this->redirect('Index/index');
		}
	}

	public function index() {
		$this->_assignTeam();
		$this->_assignAdvisor();
		$this->_assignMember();
		$this->display('changeInfo');
	}

	protected function _assignTeam() {
		$Team = M('team');
		$map['id'] = array('eq',session('uid'));
		$curTeam = $Team->where($map)->find();
		$this->assign('Team',$curTeam);
	}

	protected function _assignAdvisor() {
		$Advisor = M('advisor');
		$map['teamId'] = array('eq',session('uid'));
		$curAdvisor = $Advisor->where($map)->find();
		session('curAdvisorId',$curAdvisor['id']);
		$this->assign('Advisor',$curAdvisor);
	}


	protected function _assignMember() {
		$Member = M('member');
		$map['teamId'] = array('eq',session('uid'));
		$map['type'] = array('eq','member');
		$members = $Member->where($map)->select();
		$map2['teamId'] = array('eq',session('uid'));
		$map2['type'] = array('eq','leader');
		$leader = $Member->where($map2)->find();
		$this->assign('Leader', $leader);
		$this->assign('Members', $members);
		$memberCount = count($members) + 1;
		$this->assign('membersCount',$memberCount);
		return;
	}



	public function validateTeamName(){
		$Team = M('Team');
		$name = $_POST['name'];
		$isRepeat = $_POST['repeat'];
		// $this->redirect('Index/index',$isRepeat);
		$isExist = $Team->where('name='.'"'.$name.'"')->select();
			// echo $isExist;
		if(!$isExist)
			echo "1";
		else if($isRepeat == 'true')
			echo "1";
		else 
			echo '0';

	}

	public function validateUserName(){
		$Team = M('Team');
		$username = $_POST['name'];

		$isExist = $Team->where('username='.'"'.$username.'"')->select();
			// echo $isExist;
		if(!$isExist)
			echo "1";
		else
			echo "0";
	}


	public function deleteMember() {
		if ($this->isPost()) {
			$memberId = I('post.memberId');
			$Member = M('member');
			$condition['id'] = $memberId;
			$result	= $Member->where($condition)->delete();
			echo $result;
		} else {
			$this->error('发生错误');
		}
	}

	public function dealWithFormInfo() {
			// teacher info
		$teacherId = $_POST['teacherId'];
		$teacherName = $_POST['teacherName'];
		$teacherPos = $_POST['teacherPos'];
		$teacherDptm = $_POST['teacherDptm'];
		$teacherContact = $_POST['teacherContact'];
		$teacherContribution = $_POST['teacherContribution'];

		//team info
		$teamId = $_POST['teamId'];
		$teamName = $_POST['teamName'];
		$memberCount = $_POST['memberCount'];

		//member

		$memberIds = array();
		$memberIds	= $_POST['memberId'];

		$names = array();
		$names = $_POST['name'];

		$sids = array();
		$sids = $_POST['sid'];

		$schools = array();
		$schools =  $_POST['school'];

		$classes = array();
		$classes = $_POST['class'];

		$dorms = array();
		$dorms = $_POST['dorm'];

		$phones = array();
		$phones = $_POST['phone'];

		$sPhones = array();
		$sPhones = $_POST['sPhone'];

		$mails = array();
		$mails = $_POST['mail'];

		$qqs = array();
		$qqs = $_POST['qq'];


//deal with team table
		$Team = M('Team');
		$data['name'] = $teamName;
		$map['id'] = $teamId;
		$result = $Team->where($map)->save($data);

//deal with member table
		$Member = M('Member');
		for ($i=0; $i < $memberCount; $i++) { 
			$data = [];
			$data['name'] = $names[$i];
			$data['studentId'] = $sids[$i];
			$data['school'] = $schools[$i];
			$data['class'] = $classes[$i];
			$data['phone'] = $phones[$i];
			$data['shortphone'] = $sPhones[$i];
			$data['mail'] = $mails[$i];
			$data['qq'] = $qqs[$i];
			$data['dorm'] = $dorms[$i];

			if ($memberIds[$i] == -1 ) {
				$data['teamId'] = $teamId;
				$result = $Member->add($data);
			} else {
				$map['id'] = $memberIds[$i];
				$result = $Member->where($map)->save($data);
			}
			

		}

		//deal with teacher information
		$Advisor = M('Advisor');
		$data = array();
		$data['name'] = $teacherName;
		$data['position'] = $teacherPos;
		$data['department'] = $teacherDptm;
		$data['contact'] = $teacherContact;
		$data['contribute'] = $teacherContribution;	
		$map['id'] = $teacherId;
		$result = $Advisor->where($map)->save($data);
	
		$this->success('修改成功',U('Main/index'));	
	}


}
?>