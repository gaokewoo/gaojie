var Main = {
	showProfile : function(element) {
		element = $(element);
		layer.open({
			type: 2,
			title: '个人资料',
			maxmin: true,
			shadeClose: true, //点击遮罩关闭层
			area: ['800px' , '520px'],
			content: element.attr('data-link')
		});
	},

	showProfileEdit : function(element) {
		element = $(element);
		layer.open({
			type: 2,
			title: '个人设置',
			maxmin: true,
			shadeClose: true, //点击遮罩关闭层
			area: ['800px' , '520px'],
			content: element.attr('data-link')
		});
	},
};