$(function(){
	$('a#deleteTeam').click(function(event){
		return confirm('撤消报名意味着你将取消这次报名，也不能以此帐号登录，当然报名期内还可以重新报名,是否确认');	
	})	
}());