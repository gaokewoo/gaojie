var Privilege = {
	List : {
		popup : function(element,title) {
			element = $(element);
			layer.open({
				type: 2,
				title: title,
				maxmin: true,
				shadeClose: true, //点击遮罩关闭层
				offset: ['5%', '20%'],
				area: ['60%' , '80%'],
				content: element.attr('data-link')
			});
		},
		delete : function(element) {
			var $this = $(element);
			swal({
				title: "您确定要删除吗?",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "确认",
				cancelButtonText: "取消",
				closeOnConfirm: false
			},
			function(){
				$.ajax({
					url: '/privilege/delete?privilegeId=' + $this.attr('data-id'),
					type: "GET",
					dataType: "json",
					cache: false,
					success: function(data) {
						if (data.code == 1) {
							console.log(data);
							swal({
								title: "操作成功",
								text: data.messages,
								type: "success",
								showConfirmButton: false
							});
							setTimeout(function(){
								window.location.href=data.redirect;
							}, 2000);
							return true;
						} else {
							swal({
								title: "操作失败",
								text: data.messages,
								type: "error",
							});
							return false;
						}
					}
				});

			});
		},
		assign : function(element) {
			var $this = $(element);
			var dataType = $this.attr('data-type');
			var roleId = $('input[name="roleId"]').val();
			var flag = true;

			if (dataType == 'menu') {
				var $enabledIds = $this.parents('div.widget-title').next().find('input[name="privilege_id[]"]:enabled');
				var enabledIdVals = $this.val() + ',';

				// 获取input:checkbox的值
				$enabledIds.each(function(){
					enabledIdVals += $(this).val() + ",";
				});
				enabledIdVals = enabledIdVals.substr(0, enabledIdVals.length-1);

				if ($this.prop('checked')) {
					$enabledIds.prop("checked", true);
				} else {
					$enabledIds.prop("checked", false);
					flag = false;
				}
			} else if (dataType == 'controller') {
				var enabledIdVals = $this.val();
				if (!$this.prop('checked')) {
					flag = false;
				}
			}

			if (flag) {
				$.ajax({
					url: '/role/addPrivilege',
					type: "POST",
					dataType: "json",
					data: {"roleId": roleId, "privilegeIds": enabledIdVals},
					cache: false,
					success: function(data) {
						console.log(data);
					}
				});
			} else {
				$.ajax({
					url: '/role/removePrivilege',
					type: "POST",
					dataType: "json",
					data: {"roleId": roleId, "privilegeIds": enabledIdVals},
					cache: false,
					success: function(data) {
						console.log(data);
					}
				});
			}
		}
	}
};