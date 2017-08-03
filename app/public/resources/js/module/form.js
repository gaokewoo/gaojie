var Form = {

	messageBox : '#ServerMessageBox',
	
	callback : null,
	
	inFancybox : false,
	
	redirect : false,

	data : {},
	
	setCallback : function(callback) {
		this.callback = callback;
		return this;
	},

	submit : function(element, inFancybox) {
		if(inFancybox) {
			Form.inFancybox = true;
		}
		function success(messages, data, redirect) {
			console.log('lllll');
			var text = messages.join("<br/>\n");
			var timer = 2000;
			console.log('llllssss');
			swal({
				'title' : '操作成功',
				'text' : text,
				'type' : 'success',
				'showConfirmButton' : false,
				'timer' : timer,
				'location' : null,
			});
			console.log('sssssslllll');
			if(Form.inFancybox) {
				setTimeout(function(){parent.$.fancybox.close();}, timer);
			}
			console.log(redirect);
			if(Form.callback != null) {
				eval('('+ Form.callback +'(Form.data)' +')');
				return;
			}
			console.log('redirect');
			if(redirect) {
				console.log('faljkghakdj');
				setTimeout(function(){
					console.log('settime');
					if(Form.inFancybox) {
						console.log('parent');
						parent.location.href=redirect;
					} else {
						console.log('self');
						location.href=redirect;
					}
				}, timer);
				return;
			} else {
				console.log('ssvmmm');
				parent.location.href='';
			}

			/*setTimeout(function(){
				if(Form.inFancybox) {
					parent.location.reload();
				} else {
					location.reload();
				}
			}, timer);*/
			return;	
		};

		//	Warning: 'alert alert-block';
		//	Error: 'alert alert-error alert-block';
		//	Info: 'alert alert-info alert-block';
		//	Success: 'alert alert-success alert-block';
		function failed(messages, data, redirect) {
			$(Form.messageBox).html('');

			$(Form.messageBox).removeClass('hide');
			$(Form.messageBox).addClass('alert alert-danger alert-dismissable');
			$(Form.messageBox).append('<a class="close" href="#" onclick="$(this).parent().hide();">×</a>');
			$(Form.messageBox).append('<h4 class="alert-heading">操作失败</h4>');

			var ul = $('<ul></ul>');
			for(var i = 0; i < messages.length; i++) {
				ul.append('<li>'+ messages[i] +'</li>');
			}
			$(Form.messageBox).append(ul);
			$(Form.messageBox).show();
			scrollTo(0,0);
		}
		
		/*function response(result, status) {
			if(status !== 'success') {
				$(Form.messageBox).html('');
				$(Form.messageBox).removeClass('hide');
				$(Form.messageBox).addClass('alert alert-danger alert-dismissable');
				$(Form.messageBox).append('<a class="close" href="#" onclick="$(this).parent().hide();">×</a>');
				$(Form.messageBox).append('<h4 class="alert-heading">操作失败</h4>');
				$(Form.messageBox).show();
				return false;
			}

			result = eval('('+ result +')');

			if(result.code == 0) {
				failed(result.messages, result.data, result.redirect);
			}

			if(result.code == 1) {
				success(result.messages, result.data, result.redirect);
			}
		};*/
		
		this.data = $(element).serializeArray();
		
		$(Form.messageBox).hide();
		$(element).ajaxSubmit({
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				console.log('error');
				console.log(XMLHttpRequest.status);
				console.log(textStatus);
				console.log(XMLHttpRequest.responseText);
			},
			success : function(result, status) {
				console.log(status);
				if(status !== 'success') {
					$(Form.messageBox).html('');
					$(Form.messageBox).removeClass('hide');
					$(Form.messageBox).addClass('alert alert-danger alert-dismissable');
					$(Form.messageBox).append('<a class="close" href="#" onclick="$(this).parent().hide();">×</a>');
					$(Form.messageBox).append('<h4 class="alert-heading">操作失败</h4>');
					$(Form.messageBox).show();
					return false;
				}

				result = eval('('+ result +')');
				console.log(result.code);
				if(result.code == 0) {
					console.log('0');
					failed(result.messages, result.data, result.redirect);
				}
				if(result.code == 1) {
					console.log('1');
					success(result.messages, result.data, result.redirect);
				}
			},// post-submit callback 
			
			dataType : null, // 'xml', 'script', or 'json' (expected server response type)
			timeout : 450000,
			//callback : callback
			//target : Form.messageBox,  // target element(s) to be updated with server response 
			//url : $(this).action,			 // override for form's 'action' attribute 
			//type : 'post',						 // 'get' or 'post', override for form's 'method' attribute 
			//clearForm: true						 // clear all form fields after successful submit 
			//resetForm: true						 // reset the form after successful submit 
		}); 
		return false;
	}

};
