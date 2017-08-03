<div id="content">
  <div id="content-header" style="height:15px"></div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-content nopadding">
            <form class="form-horizontal" id="validate-form" role="form" method="post" action="/role/save">
                <div class="control-group">
                    <label class="control-label">角色名称</label>
                    <div class="controls">
                        <input class="form-control" name="name" type="text" id="name">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"></label>
                     <div class="controls">
                        <button id="submitButton" type="submit" class="btn btn-primary">提 交</button>
                    </div>
                </div>
            </form>
            </div>
            </div>
        </div>
    </div>
    </div>
</div>
<script src="/resources/js/jquery.min.js"></script> 
<script src="/resources/js/jquery.ui.custom.js"></script> 
<script src="/resources/js/bootstrap.min.js"></script> 
<script src="/resources/js/jquery.validate.js"></script> 
<script src="/resources/layer/layer.js"></script>
<script src="/resources/js/sweetalert.min.js"></script>
<script type="text/javascript">
// Form Validation
$("#validate-form").validate({
    rules:{
        name:{
            required:true
        }
    },
    errorClass: "help-inline",
    errorElement: "span",
    highlight:function(element, errorClass, validClass) {
        $(element).parents('.control-group').addClass('error');
    },
    unhighlight: function(element, errorClass, validClass) {
        $(element).parents('.control-group').removeClass('error');
        $(element).parents('.control-group').addClass('success');
    },
    submitHandler:function(form) {
        $.ajax({
            url: $(form).attr('action'),
            type: "POST",
            data: $(form).serialize(),
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
                    //2s后关闭浮层，同时刷新页面
                    setTimeout(function(){
                        //var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                        //parent.layer.close(index); //再执行关闭  
                        parent.location.href = data.redirect;
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
    }
});
</script>