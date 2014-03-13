<?php
class MainTestAction extends Action {
	public function index() {
		echo 'a';
		// $this->display('MainTest:login');
	}	
	public function checkLogin() {
		$Team = M('team');
		$username = I('post.username',0);
		$map['username'] = $username;
		$result = $Team->where($map)->find();
		if ($result) {
			$pwd = md5(I('post.password'));
			if ($result['password'] === $pwd) {
				session('ic_isLogin','true'); 
				session('uid',$result['id']);
				session('username',$result['username']);
				$this->success('成功',U('Main/index'));

			} else {
				$this->error('密码错误');
			}
		} else {
			$this->error('用户名不存在');
		}
	}	

	public function addTeam() {
	}
}
 ?>