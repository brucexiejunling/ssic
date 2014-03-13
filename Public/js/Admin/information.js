(function() {

	var $modifyBtn = $('button.modify')
	var $form = $('form.goddamn-form:eq(0)')

	// console.log($form.serialize())

	$modifyBtn.on('click', function(event) {
		event.preventDefault()
		$.ajax({
			url: URL+'/modify_information',
			type: 'POST',
			data: $form.serialize(),
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