(function($) {
	var iconPath = ''; 

	$.extend({
		validConfig : function(options){
						iconPath = options.path;
		}
	});

	$.fn.valid = function(options){
		$(this).addClass('valided')
		function isName(name, least, longest, url, isSame){
			var isValid = true;
			var info = 'connect';
			 if(name == '' || name.length < least || name.length > longest) {
					return {isValid : false, info : 'length'};
			 }
			 var prefix = this.prefix;
			 if(url) {
			 	 var isRepeat = options.repeat;
			 	 console.log(isRepeat+'fffffffffffff')
				 $.ajax({
					 url : url,
					 async : false,
					 type : 'POST',
					 data : {name:name, repeat: isSame},
					 success : function(data){
					 	console.log(data)
						 if(data =='1'){
							 isValid = true;
							 info = 'OK';  
						 } else {
							 isValid = false;
							 info = 'used';  
						 }
					 },
					 error : function(e){}
				 });
			 }
			 return {isValid : isValid, info : info};
		}

		function isPassword(password, len) {
			 return password.length >= len ? true : false; 
		}

		function focus($icon){
			$icon.css({
				'display':'inline-block',
				'background-position':'0 -64px'
			});
		}

		function isEmail(email){
				var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
				return myreg.test(email);
		}
		function isEmpty(){
		}
		this.each(function(){
				var $this = $(this);
				$this.after('<div></div><span></span>');
				$this.data('isValid',false); // You can know if is valid by this way
				$icon = $this.next();
				$info = $icon.next();
				$icon.css({
					'display':'none',
					'width':'16px',
				    'height':'16px',
				    'background':'url(' + iconPath + 'tipicon.png)',
					'margin':'0 10px'
				});
				$info.css({
					'display':'none',
					'color':'#ADADAD'
				});
		});


		if(options.type == 'name') {
			var defaults = {
				type : 'name',
				url : '',
				from : 4,
				to : 30,
				tips : 'Please input your name', 
				lengthError : 'Your names length  is no valid',
				connectError: 'Conncet Error',
				usedError: 'Your name has been used',
				success : 'OK'
			};

			var op = $.extend({}, defaults, options);

			this.each(function(){
				var $this = $(this);
				var $icon = $this.next();
				var $info = $icon.next();

				$this.focus(function(event){
					focus($icon);
					$info.css('display','inline');
					$info.text(op.tips);
				});

				$this.blur(function(event){
					var name = $(this).val();
					$icon.css({
						'background':'url(' + iconPath +'loading.gif)'
					});
					var isSame = false;
					if (op.repeat && op.previousTName == name) {
						isSame = true;
					} 
					var result = isName(name, op.from, op.to, op.url, isSame);

					$icon.css({
						'background':'url(' + iconPath  +'tipicon.png)'
					});
					if(result.isValid){
						$icon.css({
							'background-position':'0 -32px'
						});
						$info.text(op.success);
						$this.data('isValid', true);
					}else {
						$icon.css({
							'background-position':'0 -16px'
						});
						switch(result.info) {
							case 'connect' : $info.text(op.connectError);break;
							case 'length' : $info.text(op.lengthError);break;
							case 'used' : $info.text(op.usedError) ;break;
							default:break;
						}
						$this.data('isValid', false);
					}
				});
			});
		} else if(options.type == 'password') {
				var defaults = {
					type : 'name',
					tips : 'Please input your password', 
					from : 6,
					error : 'Your password is no valid',
					success : 'OK',
					$repeat : $()
				};

				var op = $.extend({}, defaults, options);

				this.each(function(){
					var $this = $(this);
					var $icon = $this.next();
					var $info = $icon.next();

					$this.focus(function(event){
						focus($icon);
						$info.css('display','inline');
						$info.text(op.tips);
					});

					var pFnc = function(event){
						var password = $this.val();
						if(isPassword(password, op.from)){
							$icon.css({
								'background-position':'0 -32px'
							});
							$info.text(op.success);
							$this.data('isValid', true);
						}else{
							$icon.css({
								'background-position':'0 -16px'
							});
							$info.text(op.error);
							$this.data('isValid', false);
						}
						op.$repeat.keyup(); 
					}
					$this.keyup(pFnc);
					$this.blur(pFnc);
				});
		} else if (options.type == 'repeat'){
				var defaults = {
					type : 'name',
					tips : 'Repeat your password', 
					error : 'Not the same ',
					success : 'OK',
					$password : $()
				};

				var op = $.extend({}, defaults, options);

				this.each(function(){
					var $this = $(this);
					var $icon = $this.next();
					var $info = $icon.next();

					$this.focus(function(event){
						focus($icon);
						$info.css('display','inline');
						$info.text(op.tips);
					}); 
					var rFnc = function(event){
						var repeat = $this.val();
						var password = op.$password.val();

						if(repeat == password && repeat != ''){
							$icon.css({
								'background-position':'0 -32px'
							});
							$info.text(op.success);
							$this.data('isValid', true);
						}else{
							$icon.css({
								'background-position':'0 -16px'
							});
							$info.text(op.error);
							$this.data('isValid', false);
						}
					}
					$this.keyup(rFnc);
					$this.blur(rFnc);
				});

		} else if(options.type == 'email'){
			var defaults = {
				type: 'email',
				tips: 'Input your email',
				error: 'You Email is not valid',
				success: 'OK',
			};

			var op = $.extend({}, defaults, options);

			this.each(function(){
				var $this = $(this);
				var $icon = $this.next();
				var $info = $icon.next();

				$this.focus(function(event){
					$info.css('display','inline');
					focus($icon);
					$info.text(op.tips);
				});
				var pFnc = function(event){
					var email = $this.val();
					if(isEmail(email)){
						$icon.css({
							'background-position':'0 -32px'
						});
						$info.text(op.success);
						$this.data('isValid', true);
					}else{
						$icon.css({
							'background-position':'0 -16px'
						});
						$info.text(op.error);
						$this.data('isValid', false);
					}
				}
				$this.keyup(pFnc);
				$this.blur(pFnc);
			});
		}
		return this;
	};
})(jQuery);
