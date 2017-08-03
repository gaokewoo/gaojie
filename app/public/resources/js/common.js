var Common = {

	alert : function(text) {
		swal({
			title: text,
			type: "info",
			closeOnConfirm: false,
		});
	},

	confirm : function(text, url, data) {
		swal({
			title: text,
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			closeOnConfirm: false,
		},
		function(){
			Common.submit(url, data, 'reload');
		});

	},

	submit : function(url, data, location, redirectUrl) {

		$.ajax({
			type : 'post',
			url : url,
			data : {'arr':data},
			dataType: "json",
			success : function(response) {
				if(response.code == 0) {
					swal({
						title: "操作失败",
						text: response.messages,
						type: "error",
					});
				} else {
					swal({
						title: "操作成功",
						text: response.messages,
						type: "success",
						showConfirmButton: false,
						timer: 2000,
						location: location,
						redirectUrl: redirectUrl,
					});
				}
			},
			error : function(response) {
				swal({
					title: "操作失败",
					text: response.messages,
					type: "error",
				});
			}
		});
	},
};
