<div id="content">
  <div id="content-header" style="height:15px"></div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-content nopadding">
            <form class="form-horizontal" id="validate-form" role="form" method="post" action="/privilege/save">
                <div class="control-group">
                    <label class="control-label">权限名称</label>
                    <div class="controls">
                        <input class="form-control" name="name" type="text" id="name">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">模块</label>
                    <div class="controls">
                        <select class="form-control" name="module_id" id="module_id">
                            <option value="">请选择</option>
                            <?php foreach ($modules as $module) {?>
                            <option value="<?php echo $module->getModuleId();?>"><?php echo $module->getName();?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">上级</label>
                    <div class="controls">
                        <select class="form-control" name="parent_id" id="parent_id">
                            <option value="">请选择</option>
                            <?php 
                            foreach ($privileges as $privilege) {
                                $padding = '';
                                for ($i=1; $i<$privilege['level']; $i++) {
                                    $padding .= "&nbsp;&nbsp;&nbsp;&nbsp;";
                                }
                                echo '<option value="' . $privilege['privilege_id'] . '">' . $padding . $privilege['name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">控制器</label>
                    <div class="controls">
                        <input class="form-control" name="controller" type="text" id="controller">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">动作</label>
                    <div class="controls">
                        <input class="form-control" name="action" type="text" id="action">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">类型</label>
                    <div class="controls">
                        <select class="form-control" name="type" id="type">
                            <option value="">请选择</option>
                            <option value="controller">控制器</option>
                            <option value="menu">菜单</option>
                            <!--<option value="navigator">导航</option>-->
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">目标地址</label>
                    <div class="controls">
                        <input class="form-control" name="target" type="text" id="target">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">图标</label>
                    <div class="controls">
                        <input class="form-control" name="icon" type="text" id="icon">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">是否显示</label>
                    <div class="controls">
                        <input type="radio" name="is_display" value="0">不显示
                        <input type="radio" name="is_display" value="1" checked="checked">显示
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">排序</label>
                    <div class="controls">
                        <input class="form-control" name="sequence" type="text" id="sequence">
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
        },
        module_id:{
            required:true
        },
        type:{
            required:true
        },
        sequence:{
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
