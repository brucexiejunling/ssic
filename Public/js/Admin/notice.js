(function() {

	var $modifyBtn = $('button.modify')
	var $information = $('textarea.information')

	$modifyBtn.on('click', function(event) {
		$.ajax({
			url: URL+'/modify_notice',
			type: 'POST',
			data: {
				content: $information.val()
			},
			success: function(data) {
				console.log(data)
				if (data.msg === 'ok') {
					alert('修改成功！')
				} else {
					alert('修改失败！')
				}
			},
			error: function(e) {
				console.error(e)
				alert('修改失败！服务器连接错误！')
			}
		})
	})

})()