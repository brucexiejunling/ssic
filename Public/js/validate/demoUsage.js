$(function(){

	$.validConfig({
		path : imgPath
	});

	var $teamName = $('input#team-name');
	var $teacherName = $('input#teacher-name');
	// var $teacherPos = $('#teacher-pos');
	// var $teacherDptm = $('#teacher-dptm');
	// var $teacherContact = $('#teacher-contact');
	// var $teacherContribute = $('#teacher-contribution');


	var $userName = $('#username');
	var $password = $('#password');
	var $repeatPwd = $('#repeat-password');

	var validation = [];
	var config = {
		type: 'name',
		from: 1,
		to: 30,
		url: false,
		tips: '必填',
		lengthError: '长度不正确',
		connectError: '连接数据错误',
	}
	

	// $teamName.valid({
	// 	type: 'name',
	// 	from: 1,
	// 	to: 30,
	// 	url: "validateTeamName",
	// 	tips: '',
	// 	lengthError: '长度不正确',
	// 	connectError: '连接数据错误',
	// 	usedError: '队名已存在',
	// });

	if ( window.previousTName) {
		$teamName.valid({
			type: 'name',
			from: 1,
			to: 30,
			url: "validateTeamName",
			repeat: 'true',
			previousTName: previousTName,
			tips: '',
			lengthError: '1-30字',
			connectError: '连接数据错误',
			usedError: '队名已存在',
		});
	} else {
		$teamName.valid({
			type: 'name',
			from: 1,
			to: 30,
			url: "validateTeamName",
			tips: '',
			lengthError: '1-30字',
			connectError: '连接数据错误',
			usedError: '队名已存在',
		});
	}


	$teacherName.valid(config);
	// $teacherPos.valid(config);
	// $teacherContribute.valid(config);
	// $teacherContact.valid(config);
	// $teacherDptm.valid(config);


	$userName.valid({
		type: 'name',
		from: 1,
		to: 30,
		url: "validateUserName",
		tips: '',
		lengthError: '1-30字',
		connectError: '连接数据错误',
		usedError: '账号已存在',
	})

	$password.valid($.extend(config,{from: 6, to: 24,lengthError: "长度6至24"}))

	$repeatPwd.valid({
		type: 'repeat',
		tips : '确认密码', 
		error : '密码不一致',
		success : 'OK',
		$password : $password
	})

});
