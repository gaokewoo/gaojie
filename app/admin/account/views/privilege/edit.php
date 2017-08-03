<div id="content">
  <div id="content-header" style="height:15px"></div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-content nopadding">
            <form class="form-horizontal" id="validate-form" role="form" method="post" action="/privilege/modify">
            <input type="hidden" name="privilegeId" value="<?php echo $privilegeCur->getPrivilegeId();?>" />
                <div class="control-group">
                    <label class="control-label">权限名称</label>
                    <div class="controls">
                        <input class="form-control" name="name" type="text" id="name" value="<?php echo $privilegeCur->getName();?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">模块</label>
                    <div class="controls">
                        <select class="form-control" name="module_id" id="module_id">
                            <option value="">请选择</option>
                            <?php foreach ($modules as $module) {?>
                            <option value="<?php echo $module->getModuleId();?>" <?php if($module->getModuleId() == $privilegeCur->getModuleId()) { echo 'selected="selected"'; }?>><?php echo $module->getName();?></option>
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
                                if ($privilege['privilege_id'] == $privilegeCur->getParentId()) {
                                    echo '<option value="' . $privilege['privilege_id'] . '" selected="selected">' . $padding . $privilege['name'] . '</option>';
                                } else {
                                    echo '<option value="' . $privilege['privilege_id'] . '">' . $padding . $privilege['name'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">控制器</label>
                    <div class="controls">
                        <input class="form-control" name="controller" type="text" id="controller" value="<?php echo $privilegeCur->getController();?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">动作</label>
                    <div class="controls">
                        <input class="form-control" name="action" type="text" id="action" value="<?php echo $privilegeCur->getAction();?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">类型</label>
                    <div class="controls">
                        <select class="form-control" name="type" id="type">
                            <option value="">请选择</option>
                            <option value="controller" <?php if($privilegeCur->getType() == Model_Privilege::TYPE_CONTROLLER) { echo 'selected="selected"'; } ?>>控制器</option>
                            <option value="menu" <?php if($privilegeCur->getType() == Model_Privilege::TYPE_MENU) { echo 'selected="selected"'; } ?>>菜单</option>
                            <!--<option value="navigator" <?php if($privilegeCur->getType() == Model_Privilege::TYPE_NAVIGATOR) { echo 'selected="selected"'; } ?>>导航</option>-->
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">目标地址</label>
                    <div class="controls">
                        <input class="form-control" name="target" type="text" id="target" value="<?php echo $privilegeCur->getTarget();?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">图标</label>
                    <div class="controls">
                        <input class="form-control" name="icon" type="text" id="icon" value="<?php echo $privilegeCur->getIcon();?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">是否显示</label>
                    <div class="controls">
                        <input type="radio" name="is_display" value="0" <?php if($privilegeCur->getIsDisplay() == Model_Privilege::NOT_DISPLAY) { echo 'checked="checked"'; } ?>>不显示
                        <input type="radio" name="is_display" value="1" <?php if($privilegeCur->getIsDisplay() == Model_Privilege::IS_DISPLAY) { echo 'checked="checked"'; } ?>>显示
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">排序</label>
                    <div class="controls">
                        <input class="form-control" name="sequence" type="text" id="sequence" value="<?php echo $privilegeCur->getSequence();?>">
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
                console.log(data.code);
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