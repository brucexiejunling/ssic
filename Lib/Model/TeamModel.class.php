<?php
	class TeamModel extends Model{
		
		public  $temp = array();


		// protected $_validate = array(
		//    array('verify','require','验证码必须！'), //默认情况下用正则进行验证
		//    array('name','','帐号名称已经存在！',0,'unique',1), // 在新增的时候验证name字段是否唯一
		//    array('value',array(1,2,3),'值的范围不正确！',2,'in'), // 当值不为空的时候判断是否在一个范围内
		//    array('repassword','password','确认密码不正确',0,'confirm'), // 验证确认密码是否和密码一致
		//    array('password','checkPwd','密码格式不正确',0,'function'), // 自定义函数验证密码格式
		// );

		public function getTeamName($tid=0) {
			$Team = D('Team');
			if($tid == 0){
				$tname = $Team->order('id')->getField('name',true);
				$teamId = $Team->getField('id',true);
				$Member = M('Member');
				$members = array();
				for($i=0;$i<count($teamId);$i++){
					$memberForOneTeam = array();
					$memberForOneTeam = $Member->where('teamId='.'"'.$teamId[$i].'"')->getField('name',true);
					$memberNameForOneTeam = join(' ',$memberForOneTeam);
					array_push($members,$memberNameForOneTeam);
				}

				$this->$temp = $members;

			}else{
				$tname = $Team->where('id='.$tid)->getField('name');
			}
			return $tname;
		}

		public function getTeamCount(){
			$Team = M('Team');
			$teamCount = $Team->count();
			return $teamCount;
		}

		public function getTeamMembers() {
			return $this->$temp;
		}

		public function isValid($username,$password) {
			$isLogin = session('ic_isLogin');

			if(session('ic_isLogin') && $isLogin == 'true') {
				$loginInfo = "isLogin";
			}
			else{
				$Team = M('Team');
				// $result = $Team->where('username="'.$username.'" AND password="'.$password.'"')->find();
				$condition['username'] = $username;
				$result = $Team->where($condition)->find();
				if($result){
					// $uid =  $Team->where('username="'.$username.'" AND password="'.$password.'"')->getField('id');
					if ($result['password'] === $password) {
						session('uid',$result['id']);
						session('ic_isLogin',"true");
						$loginInfo = "success";
					} else {
						$loginInfo = 'wrongPassword';
					}
				}else{
						$loginInfo = "invalid";
				}
			}

			return $loginInfo;
			
		}

	}
?>