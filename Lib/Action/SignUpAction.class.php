<?php
	class SignUpAction extends Action {

		public function _initialize() {
			$canAccess = D('Period')->isNowInPeriod('apply');	
			if (!$canAccess) {
				$this->redirect('Index/index');
			}
		}

		public function signUp() {
			$this->display();
		}


		public function validateTeamName(){
			$Team = M('Team');
			$name = $_POST['name'];
			$isExist = $Team->where('name='.'"'.$name.'"')->select();
			// echo $isExist;
			if(!$isExist)
				echo "1";
			else
				echo "0";
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
		public function dealWithFormInfo() {
			// teacher info
			$teacherName = $_POST['teacherName'];
			$teacherPos = $_POST['teacherPos'];
			$teacherDptm = $_POST['teacherDptm'];
			$teacherContact = $_POST['teacherContact'];
			$teacherContribution = $_POST['teacherContribution'];

			//team info
			$teamName = $_POST['teamName'];
			$username = $_POST['username'];
			$password = $_POST['password'];
			$memberCount = $_POST['memberCount'];

			//member
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
			$Team = D('Team');
			$data['name'] = $teamName;
			$data['username'] = $username;
			$data['password'] = $password;

			if($Team->create($data)){
				$teamId = $Team->add($data);
			}else {
				$this->error($Team->getError());
			}	

//deal with member table
			$Member = D('Member');
			for ($i=0; $i < $memberCount; $i++) { 
				$data = array();
				$data['teamId'] = $teamId;
				$data['name'] = $names[$i];
				$data['studentId'] = $sids[$i];
				$data['school'] = $schools[$i];
				$data['class'] = $classes[$i];
				$data['phone'] = $phones[$i];
				$data['shortphone'] = $sPhones[$i];
				$data['mail'] = $mails[$i];
				$data['qq'] = $qqs[$i];
				$data['dorm'] = $dorms[$i];

				if ($i == 0) {
					$data['type'] = 'leader';
				}

				if($Member->create($data)){
					$Member->add($data);
					// $this->success('恭喜你报名成功，请用登陆账号登陆查看队伍参赛信息！');
				}else {
					$this->error($Member->getError());
				}	
			}

		//deal with teacher information
			$Advisor = D('Advisor');
			$data = array();

			$data['teamId'] = $teamId;
			$data['name'] = $teacherName;
			$data['position'] = $teacherPos;
			$data['department'] = $teacherDptm;
			$data['contact'] = $teacherContact;
			$data['contribute'] = $teacherContribution;	

			if($Advisor->create($data)){
				$Advisor->add($data);
				$this->success('恭喜你报名成功，请用登陆账号登陆查看队伍参赛信息！',U('Index/index'),5);
			}else {
				$this->error($Advisor->getError());
			}		
		}
	}
?>