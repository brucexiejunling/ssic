$(function(){
	// $.post('isLogin',{test:'test'},function(data){
	// 	if(data == "true")
	// 		showLogOut()
	// 	else
	// 		showLogin()
	// })


	checkOutPeriod();

	function checkOutPeriod(){
		// isInVotePeriod();
		isInSignUpPeriod();
	}

	function isInVotePeriod(){
		$.post(URL + '/isInVotePeriod',function(result){
		if(result)
			enableVote();
		else
			disableVote();
		});
	}

	function isInSignUpPeriod(){
		$.post(URL + '/isInSignUpPeriod',function(result){
		if(result)
			enableSignUp();
		else
			disableSignUp();
		});
	}

	enableVote = function(){
		$('li#vote').removeClass('disabled');
	}

	disableVote = function() {
		$('li#vote').addClass('disabled');
	}

	enableSignUp = function() {
		$('li#sign-up').removeClass('disabled');
	}

	disableSignUp = function() {
		$signUp = $('li#sign-up');
		$signUp.find('a').html("报名已结束");
		$('li#sign-up').addClass('disabled');
	}

	$loginBtn = $('a.login');
	$loginBtn.click(function(event){
		event.preventDefault();
		$loginDialog = $('div.login-dialog');
		if(!($loginDialog.hasClass('dialog-visible')))	{
			$loginDialog.slideDown(500,function(){
				$(this).addClass('dialog-visible');
			});
		}else {
			$loginDialog.slideUp(500,function(){
				$(this).removeClass('dialog-visible');
			})
		}
	});

	navToVotePage = function() {

	}


	$('#login-form button').click(function(event){
		event.preventDefault();
		var userName = $('form input.username')[0].value;
		var passWord = $('form input.password')[0].value;
		var root = 'Index/';
		if(userName != ""){
			$.post(URL + '/validate',{username: userName, password: passWord},function(data){
				if(data == "success")
					login();
				else
					showError(data);
			});
		}

		function login(){
			alert('登录成功,你可以点击‘我的团队’以查看相关信息。');
			showLogOut();

		}

		function showError(error) {
			if(error == "isLogin")
				alert('不能重复登录哦亲');
			else if (error === 'wrongPassword')
				alert('密码不正确');
			else 
				alert('用户名不正确');
		}

	})

	function showLogOut(){
		$("#login").css('display','none');
		$('div.login-dialog').css('display','none');
		$('#after-login').css('display','block');

	}

	$('#logOut').click(function(event){
		event.preventDefault();
		$.post(URL+'/logOut',function(info){
			alert('登出成功');
			showLogin();
		})
		
	})

	function showLogin(){
		$('#after-login').css('display','none');
		$("#login").css('display','block');

	}
	$('a.vote').click(function(event){
		event.preventDefault();
	})
	$('li.disabled').click(function(event){
		event.preventDefault();
	})
});