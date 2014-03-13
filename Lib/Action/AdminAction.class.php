<?php 
/**
* Admin Management
*/
class AdminAction extends Action {

	protected $currentPage;

	protected $navs;

	public function _initialize() {
		if (!(session('?adminLogin') && session('adminLogin')=='login')) {
			$this->redirect('AdminLogin/index');
		}


		$this->navs = $this->get_navs();
	}

// 	public function changetest() {
// 		$Contest = M('Contest_info');
// 		$ContestIn = $Contest->where('id=1')->find();
// 		dump($ContestIn);
// 		// $data['information'] = "中山大学软件创意创新设计大赛，旨在营造更好的创新氛围，激发新灵感。大赛分为两个部分：新生软件创意大赛与软件创新与应用大赛，两个比赛同时启动，同时进行，赛程独立。
// // 软件创新与应用大赛，提供一个平台让同学们学以致用，把创新想法付诸于实践，在体验项目开发的过程中培养团队合作与交流能力。同时，提倡跨专业组队，从不同角度去创新去设计，更能开阔思维，诞生优秀的作品。本次创新大赛主题为“云+端”，同学们可以围绕主题放飞灵感，我们期待你的作品！";
// 		// $result = $Contest->where('id=1')->save($data);
// 		// if($result)
// 			// $this->success('test','information');
// 		// else
// 			// dump($result);
// 			// $this->error('no');	
// 	}

	public function _empty() {
		$param = $this->_param(1);
		$operator = isset($this->navs[$param]) ? $param : 'information';
		$this->render_empty_page($operator);
	}

	public function information() {
		$this->render_sidebar('information');

		$contestInfo = M('Contest_info')->where('id=1')->getField('id,info,route,rule', true);
		$this->assign($contestInfo[1]);
		$this->display();
	}

	public function modify_information() {

		if ($this->isPost()) {

			$Contest = M('Contest_info');

			$data['id'] = 1;
			$data['info'] = I('post.info');
			$data['rule'] = I('post.rule');
			$data['route'] = I('post.route');

			$Contest->save($data);

			$this->ajaxReturn(array(
				'msg'=>'ok'
			));

		} else {
			$this->error('你进错门了！！');
		}

	}

	public function notice() {
		$this->render_sidebar('notice');

		$Contest = M('Contest_info')->find(1);
		$this->assign('notice', $Contest['announction']);

		$this->display();
	}

	public function modify_notice() {

		if ($this->isPost()) {

			$modified_info = I('post.content');
			$Contest = M('Contest_info')->where('id=1');
			$result = $Contest->setField('announction', $modified_info);

			if ($result) {
				$msg = 'ok';
			} else {
				$msg = 'fail';
			}

 			$data = array(
				'msg'=>$msg
			);

			$this->ajaxReturn($data);

		} else {
			$this->error('你进错门了！！');
		}

	}

	public function teams_status() {
		$Teams = M('Team');
		$Period = D('Period');
		$map = $Period->mapping;

		$in_teams = $Teams->where('status="in"')->select();
		$out_teams = $Teams->where('status="out"')->select();
		$revive_teams = $Teams->where('status="revive"')->select();
		$teams = array_merge((array)$in_teams, (array)$out_teams, (array)$revive_teams);

		$this->assign('map', $map);
		$this->assign('teams', $teams);
		$this->render_sidebar('teams_status');
		$this->display();
	}

	public function modify_teams_status() {

		if($this->isPost()) {
			$modified_team_status = $_POST;
			$arr = [];
			$Teams = M('Team');

			$Period = D('Period');
			$currentPage = $Period->getCurrentStage();

			foreach ($modified_team_status as $id=>$status) {
				$team_status['id'] = $id;
				$team_status['status'] = $status;

				if ($status == 'out') {
					$team_status['outStage'] = $currentPage;
				} else {
					$team_status['outStage'] = '--';
				}

				$Teams->save($team_status);
			}

			$msg = 'ok';
			$this->ajaxReturn(array('msg'=>$msg));

		} else {
			$this->error('你进错门了！！');
		}

	}

	public function period() {
		$periods = M('Period')->select();

		$this->assign('periods', $periods);

		$this->render_sidebar('period');
		$this->display();
	}

	public function modify_period() {
		$modified_periods = $_POST['periods'];
		$periods = M('Period'); 

		foreach ($modified_periods as $period) {
			$periods->save($period);
		}

		$this->ajaxReturn(array(
			'msg'=>'ok'
		));
	}

	protected function render_empty_page($activeItem) {
		$this->render_sidebar($activeItem);
		$this->display($activeItem);
	}

	protected function render_sidebar($activeItem) { 
		$this->currentPage = $activeItem;
		$this->navs[$activeItem]['active'] = 'active';
		$this->assign('navs', $this->navs);
	}

	protected function get_navs() {

		$navs = array(
			'information'=> array(
				'name'=>'修改大赛主页信息',
				'url'=>U('Admin/information'),
			),

			'showTeam' => array(
				'name' =>'查看队伍信息',
				'url' =>U('Admin/showTeam'),
			),

			'notice'=> array(
				'name'=>'修改大赛公告',
				'url'=>U('Admin/notice'),
			),

			'period'=> array(
				'name'=>'修改各阶段时间',
				'url'=>U('Admin/period'),
			),

			'teams_status'=> array(
				'name'=>'修改各队伍晋级状态',
				'url'=>U('Admin/teams_status'),
			),

			'teachers_settings'=> array(
				'name'=>'点评老师设定',
				'url'=>U('Admin/draw_settings'),
			),

			'draw_settings'=> array(
				'name'=>'抽签时间地点设定',
				'url'=>U('Admin/draw_settings'),
			),

			'draw'=> array(
				'name'=>'抽签',
				'url'=>U('Admin/draw'),
			),

		);

		return $navs;
	}


	//edited by kuangweike 
	public function showTeam() {
		$this->render_sidebar('showTeam');
		$Team = M('team');
	   	$teams = $Team->select();
	   	$this->assign('teams',$teams);
	   	$this->display('showTeam');
	}

	public function deleteTeam() {

		if ($this->isPost()) {

			$Team = M('team');

			$id = I('post.teamId');

			$condition['id'] = $id; 

			$result = $Team->where($condition)->delete();

			$this->ajaxReturn(array(
				'msg'=>'ok'
			));

		} else {
			$this->error('你进错门了！！');
		}

	}
	
	public function moreInfo() {
		$teamId = I('get.teamId');	

		$Advisor = M('advisor');
		$condition['teamId'] = $teamId;
		$Advisors = $Advisor->where($condition)->select();
		$this->assign('Advisors',$Advisors);

		$Member = M('member');
		$map['teamId'] = array('eq',$teamId);
		$map['type'] = array('eq','member');
		$members = $Member->where($map)->select();
		$map2['teamId'] = array('eq',$teamId);
		$map2['type'] = array('eq','leader');
		$leader = $Member->where($map2)->find();
		$this->assign('leader', $leader);
		$this->assign('members', $members);

		$this->display('moreInfo');
	}	



	//数据库操作
	public function CHECKTEAM() {
		$T = M('team');
		$result = $T->where('id=44')->find();
		dump($result);
	}

	public function ADDCLO() {
		$db = M();
		$sql = "alter table ic_team add platform varchar(100) default NULL";
		$ret = $db->execute($sql);
		echo $ret;
	}

	public function ORDERTEAM() {
		$Team = M('Team');
		$teams = $Team->select();
		$num = 1;
		foreach ($teams as $key => $team ) {
			$teamId = $team['id'];
			$data['number'] = $num; 
			$result = $Team->where("id=$teamId")->setField($data);
			$num++;
		}
		$this->redirect('GETORDER');
	}
	public function GETORDER() {
		$Team = M('Team');
		$length = $Team->count();
		echo 'length=';
		echo $length;
		$Team = M('Team');
		$teams = $Team->select();

		foreach ($teams as $key => $team ) {
			$teamId = $team['id'];
			$data['number'] = $num; 
			$result = $Team->where("id=$teamId")->getField($data);
			$num++;
			dump($result);
		}

	}

}

?>
