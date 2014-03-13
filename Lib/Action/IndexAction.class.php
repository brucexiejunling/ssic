<?php

class IndexAction extends Action {

    public function _empty() {
        $this->redirect('Index/index');
    }

    public function index() {
        // dump(session('uid'));
        // dump(session('isLogin'));
        $this->showInfo();
        $this->showTeam();
        $value = 5;
        $this->assign('value',$value);
        if (session("?ic_isLogin") && session('ic_isLogin') == 'true') {
            $isLogin = 'true'; 
        } else {
            $isLogin = 'false'; 
        }

        $canApply = D('Period')->isNowInPeriod('apply');

        $this->assign('canApply', $canApply);

        $this->assign('isLogin',$isLogin);
        $this->display();
    } 

    public function showInfo(){
        $Contest_info = M('Contest_info');
        $this->showintro($Contest_info);
        $this->showRule($Contest_info);
        $this->showRoute($Contest_info);
        $this->showContact($Contest_info);
        $this->showAnnouncement($Contest_info);
    }

    public function alert() {
        $this->display();
    }

    public function showintro($Contest_info) {
        $this->contest_intro = $Contest_info->where('id=1')->getField('info');

    }

    public function showRule($Contest_info) {
        $this->contest_rule = $Contest_info->where('id=1')->getField('rule');
    }

    public function showRoute($Contest_info) {
        $this->contest_route = $Contest_info->where('id=1')->getField('route');
    }

    public function showContact($Contest_info) {
        $this->contest_contact = $Contest_info->where('id=1')->getField('contact');
    }

    public function showAnnouncement($Contest_info) {
        $this->contest_anno = $Contest_info->where('id=1')->getField('announction');
    }

    public function showTeam() {
        $Team = D('Team');
        $tname = $Team->getTeamName();
        $this->assign('Tname',$tname);
        $teamCount = $Team->getTeamCount();
        $teamMember = $Team->getTeamMembers();
        // $perPage = $teamCount > 11 ? 11 : $teamCount;

        // $isInt = $teamCount%$perPage ? 0 : 1; 
        // $pageCount = $isInt ? $teamCount/$perPage : (int)($teamCount/$perPage) + 1;
        // $this->assign('pageCount',$pageCount);
        $this->assign('members',$teamMember);
        $this->assign('teamCount',$teamCount);
    }

    public function isInVotePeriod(){
        $PeriodModel = D('Period');
        $bool = $PeriodModel->isNowInPeriod("revive_vote");
        echo $bool;
    }

    public function isInSignUpPeriod() {
        $PeriodModel = D('Period');
        $bool = $PeriodModel->isNowInPeriod("apply");
        echo $bool;      
    }

    public function validate() {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $Team = D('Team');
        $result = $Team->isValid($username,$password);
        $this->ajaxReturn($result);
    }

    // public function validate() {
    //     $this->ajaxReturn('wrongPassword');
    // }

    public function isLogin() {
        $loginStatus = session('ic_isLogin');
        if($loginStatus == "true")
            echo "true";
        else
            echo "false";
    }

    public function logOut() {
        session(null);
        echo "ok";
    }
}
?>