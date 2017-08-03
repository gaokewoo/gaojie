var ImageAutoUpload = {

	//图片类型
	mime: 'image/png',

	//文件ID
	fileId: '',

	//图片ID
	targetId: '',

	//图片地址ID
	urlId: '',

	//图片宽度
	width: 0,

	//图片高度
	height: 0,

	//上传地址
	uploadUrl: '',

	//添加图片
	addFile: function() {

		var element = document.getElementById(ImageAutoUpload.fileId);
		var file = element.files[0];

		if(!file.type.match('image.png')) {
			Common.alert('图片格式有误，请重新选择');
			return false;
		}

		var canvas = document.createElement("canvas");
		var context = canvas.getContext("2d");
		var image = new Image;
		image.src = URL.createObjectURL(file);

		image.onload = function() {
			var width = ImageAutoUpload.width;
			var height = ImageAutoUpload.height;
			
			if (image.width != 1050 || image.height != 500) {
				Common.alert("图片尺寸不符合要求");
				return false;
			}
			canvas.width = height;
			canvas.height = width;
			context.drawImage(image, 0, 0, height, width);

			var canvasToDtaUrl = canvas.toDataURL('image/png');
			document.getElementById(ImageAutoUpload.targetId).innerHTML = "<div class='thumbnail'><img src='" + canvasToDtaUrl + "'></div>";
			//$('#'+ImageAutoUpload.targetId).innerHTML = "<div class='thumbnail'><img src='" + canvasToDtaUrl + "'></div>";
		};
	},

	uploadImage: function() {
		var url  = ImageAutoUpload.uploadUrl;
		var name = ImageAutoUpload.name;
		var uid  = ImageAutoUpload.uid;
		var tianyanLogo = ImageAutoUpload.tianyanLogo;
		var teamId = ImageAutoUpload.teamId;
		var imageData = $('#'+ImageAutoUpload.targetId+' > div > img').attr('src');
		if (imageData == null || imageData == "") {
			Common.alert("未选择图片，不能上传");
			return false;
		}
		
		$.ajax({
			type : 'post',
			dataType : 'json',
			url : url,
			data : {
				'image_data': imageData,
				'name'      : name,
				'uid'       : uid,
				'tianyan_logo' : tianyanLogo,
				'teamId'    : teamId,
			},
			success : function(response) {
				if (response.code == 1) {
					console.log(response);
					swal({
						title: "操作成功",
						text: response.messages,
						type: "success",
						showConfirmButton: false, 
					});
					setTimeout(function(){
						parent.location.href=response.redirect;
					}, 2000);
					return true;
				} else {
					swal({
						title: "操作失败",
						text: response.messages,
						type: "error",
					});
					return false;
				}
			},
			error : function(response) {
				Common.alert('上传失败');
			}
		});
	},

	//设置参数
	setParams: function(params) {
		ImageAutoUpload.fileId = params.fileId;
		ImageAutoUpload.targetId = params.targetId;
		ImageAutoUpload.urlId = params.urlId;
        ImageAutoUpload.name  = params.name;
        ImageAutoUpload.uid   = params.uid;
        ImageAutoUpload.tianyanLogo = params.tianyan_logo;
        ImageAutoUpload.teamId = params.teamId;
		ImageAutoUpload.width = params.width;
		ImageAutoUpload.height = params.height;
		ImageAutoUpload.uploadUrl = params.uploadUrl;
	},
}