(function() {
	var $teamsForm = $('form.teams-form:eq(0)')
	var $submit = $('button.modify')

	$submit.on('click', function(event) {
		var $teamsData = $teamsForm.serialize()
		console.log($teamsData)

		$.ajax({
			url: 'modify_teams_status',
			type: 'POST',
			data: $teamsData,
			success: function(data) {
				console.log(data)
				if (data.msg === 'ok') {
					alert('修改成功！')
					window.location.reload()
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