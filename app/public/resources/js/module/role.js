var Role = {
	List : {
		popup : function(element, title) {
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
		checkedAll : function(element) {
			var $this = $(element);
			var checkedStatus = element.checked;
			var checkbox = $this.parents('.widget-box').find('tr td:first-child input:checkbox');
			checkbox.each(function() {
				this.checked = checkedStatus;
				if (checkedStatus == element.checked) {
					$this.closest('.checker > span').removeClass('checked');
				}
				if (element.checked) {
					$this.closest('.checker > span').addClass('checked');
				}
			});
		},
		delete : function(element) {
			$this = $(element);
			var checkbox = $this.parents('.widget-box').find('tr td:first-child input:checkbox');
			var ids = '';
			checkbox.each(function() {
				if (this.checked == true) {
					ids += ',' + $(this).val();
				}
			});
			ids = ids.substr(1, ids.length-1);

			swal({
				title: "您确定要删除吗？",
				type: "warning",
				showCancelButton: true,
				confirmButtonText: "确认",
				cancelButtonText: "取消",
				closeOnConfirm: false
			},function(){
				$.ajax({
					url: '/role/delete',
					type: "GET",
					dataType: "json",
					data: {"ids": ids},
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
	}
};