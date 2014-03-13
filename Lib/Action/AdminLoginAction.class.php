<?php
class AdminLoginAction extends Action {
	public function index() {
		$this->display('login');
	}	
	public function checkLogin() {
		$Admin = M('administrator');
		$username = I('post.username',0);
		$map['username'] = $username;
		$result = $Admin->where($map)->find();
		if ($result) {
			$pwd = I('post.password');
			if ($result['password'] === $pwd) {
				session('adminLogin','login'); 
				$this->success('成功',U('Admin/information'));

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