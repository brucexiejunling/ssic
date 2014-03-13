$(function(){


	$seleteBtn = $('button.platform-submit').click(function(event){
		event.preventDefault();
		var	$select =  $('select.select-platform');
		var preValue = $select[0].value;
		$.ajax({
			url: URL+'/dealWithPlatform',
			type: 'POST',
			data: {
				platform: preValue
			},
			success: function(data) {
				if(data['msg'] == 'ok') {
					window.location.reload();
					alert('修改成功');
				} else {
					alert('修改失败');
				}
			},
			error: function(e) {
				console.error(e)
				alert('修改失败！服务器连接错误！')
			}
		})
	})

}());