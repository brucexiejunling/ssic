(function() {

	$('.datepicker').datepicker()

	var $modifyBtn = $('button.modify')
	var $periods = $('tr.period')

	$modifyBtn.on('click', function(event) {
		var modifiedPeriods = [] 

		$periods.each(function(i, period) {
			$period = $(period)

			var id = $period.data('id')
			var startTime = $period.find('input[name=startTime]:eq(0)').val() 
			var endTime = $period.find('input[name=endTime]:eq(0)').val() 

			var startTimeHour = $period.find('select[name=startTime-hour]:eq(0)').val() 
			var endTimeHour = $period.find('select[name=endTime-hour]:eq(0)').val() 

			modifiedPeriods.push({
				id: id,
				startTime: startTime + ' ' + startTimeHour + ':00:00',
				endTime: endTime + ' ' + endTimeHour + ':00:00'
			})
		})

		console.log(modifiedPeriods)

		$.ajax({
			url: 'modify_period',
			type: 'POST',
			data: {
				periods: modifiedPeriods
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

