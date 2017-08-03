var Repair= {
	List : {
		popup : function(element, title) {
			element = $(element);
			layer.open({
				type: 2,
				title: title,
				maxmin: true,
				shadeClose: true, //点击遮罩关闭层
                scrollbar: false,
				offset: ['3%', '1%'],
				area: ['98%' , '80%'],
				content: element.attr('data-link')
			});
		},
		delete : function(id) {
			swal({
				title: "您确定要删除吗？",
				text: "删除后不可再添加！",
				type: "warning",
				showCancelButton: true,
				confirmButtonText: "确认",
				cancelButtonText: "取消",
				closeOnConfirm: false
			},function(){
				$.ajax({
					url: '/car/repair/delete',
					type: "GET",
					dataType: "json",
                    data: {"repairId": id},
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
	},

};
