$(function(){
	$select =  $('select.member-count');
	var preValue = $select[0].value;

	var $tpl = $('<div class="bs-docs-example block-member float-left"><div class="member"><div><span class="block-label">姓名:</span><input class="person-name" name="name[]" type="text"></div><div><span class="block-label">学号:</span><input class="student-id"name="sid[]" type="text"></div><div><span class="block-label">学院:</span><input class="school" name="school[]" type="text"></div><div><span class="block-label">专业班级:</span><input class="class"  name="class[]" type="text"> </div><div><span class="block-label">宿舍:</span><input class="dorm" name="dorm[]" type="text"></div><div><span class="block-label">手机:</span><input class="phone" name="phone[]" type="text"></div><div><span class="block-label">短号:</span><input class="sPhone" name="sPhone[]" type="text"></div><div><span class="block-label">邮箱:</span><input class="mail"  name="mail[]" type="text"></div><div><span class="block-label">QQ:</span><input class="qq" name="qq[]" type="text"></div></div></div></div>')
	$.validConfig({
		path : imgPath
	});

	// console.log($tpl.html())
	$select.change(function(){
		var value = this.value;
		if(value > preValue)
			addItems(value - preValue);
		else
			removeItems(preValue - value);

		preValue = value;
	});

	function addItems(count) {
		$teamInfo = $('div.team-info');

		for(var i=1; i<=count; i++){
			$newItem = $tpl.clone();
			// console.log($tpl);
			$newItem.insertBefore($('div.confirm:eq(0)').parent())
			bindValidationToNewItem($newItem);
		}
	}

	function removeItems(count) {
		for(var i=1;i<=count;i++){
			$('div.block-member:last').remove();
		}

	}

	function bindValidationToNewItem ($item) {
		var $name= $item.find('input.person-name');
		var $sid = $item.find('input.student-id');
		var $school = $item.find('input.school');
		var $class_ = $item.find('input.class');
		var $dorm = $item.find('input.dorm');
		var $phone = $item.find('input.phone');
		var $sPhone = $item.find('input.sPhone');
		var $mail = $item.find('input.mail');
		var $QQ = $item.find('input.qq');

		var validation = [];
		var config = {
			type: 'name',
			from: 1,
			to: 30,
			url: false,
			tips: '必填',
			lengthError: '1-30字',
			connectError: '连接数据错误',
		}
	
		var sidconfig = {
			type: 'name',
			from: 8,
			to: 8,
			url: false,
			tips: '8位数字',
			lengthError: '长度不正确',
			connectError: '连接数据错误',
		}


		$name.valid(config);
		$sid.valid(sidconfig);
		$school.valid(config);
		$phone.valid({
			type: 'name',
			from: 11,
			to: 11,
			url: false,
			tips: '11个数字',
			lengthError: '长度不正确',
			connectError: '连接数据错误',
		});

		$class_.valid(config);
		$dorm.valid(config);
		$mail.valid($.extend({},config,{type: 'email',error: '格式不正确',success:'ok'}))
		$QQ.valid(config);
	}


	$('button.submit').click(function(event){	
		var isValid = true;
		$('input.valided:visible').each(function(i){
			var flag = $(this).data('isValid');
			// console.log(flag);
			if(!flag){
				isValid = false;
			};
		})

		if(!isValid){
			event.preventDefault();			
			alert('请完善报名信息^o^');
		}

	})
	var $leader = $('div.block-leader');
	bindValidationToNewItem($leader);	
	addItems(2);
});