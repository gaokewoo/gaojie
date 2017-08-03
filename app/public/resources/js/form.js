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

			var text = messages.join("<br/>\n");
			var timer = 4000;

			swal({
				'title' : '操作成功',
				'text' : text,
				'type' : 'success',
				'showConfirmButton' : false,
				'timer' : timer,
				'location' : null,
			});

			if(Form.callback != null) {
				eval('('+ Form.callback +'(Form.data)' +')');
				return;
			}

			if(redirect) {
				setTimeout(function(){
					if(Form.inFancybox) {
						parent.location.href=redirect;
					} else {
						location.href=redirect;
					}
				}, 2000);
				return;
			}

			setTimeout(function(){
				if(Form.inFancybox) {
					parent.location.reload();
				} else {
					location.reload();
				}
			}, timer);
			return;	
		};

		//	Warning: 'alert alert-block';
		//	Error: 'alert alert-error alert-block';
		//	Info: 'alert alert-info alert-block';
		//	Success: 'alert alert-success alert-block';
		function failed(messages, data, redirect) {
			swal({
				title: messages,
				type: "info",
				closeOnConfirm: false,
			});
		}
		
		function response(result, status) {

			result = eval('('+ result +')');

			if(result.code == 0) {
				failed(result.messages, result.data, result.redirect);
			}

			if(result.code == 1) {
				success(result.messages, result.data, result.redirect);
			}
		};
		
		this.data = $(element).serializeArray();
		$(Form.messageBox).hide();
		$(element).ajaxSubmit({
			success : response,  // post-submit callback 
			dataType : null,		 // 'xml', 'script', or 'json' (expected server response type)
			timeout : 3000,
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

