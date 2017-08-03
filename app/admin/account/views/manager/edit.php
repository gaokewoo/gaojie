<div id="content">
  <div id="content-header" style="height:15px"></div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-content nopadding">
            <form class="form-horizontal" id="validate-form" role="form" method="post" action="/manager/modify">
            <input name="manager_id" type="hidden" value="<?php echo $manager->getManagerId();?>" />
                <div class="control-group">
                    <label class="control-label">姓名</label>
                    <div class="controls">
                        <input class="form-control" name="given_name" type="text" id="given_name" value="<?php echo $manager->getGivenName();?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">员工类型</label>
                    <div class="controls">
                        <select id="type" class="form-control" name="type" onclick="Manager.staffTypeSwitch(this);">
                            <option value="<?php echo Dao_Manager::TYPE_FULLTIME ;?>" <?php if($manager->getType() == Dao_Manager::TYPE_FULLTIME) {?>selected="selected"<?php }?>>正式员工</option>
                            <option value="<?php echo Dao_Manager::TYPE_INTERN ;?>" <?php if($manager->getType() == Dao_Manager::TYPE_INTERN) {?>selected="selected"<?php }?>>实习生</option>
                            <option value="<?php echo Dao_Manager::TYPE_PARTTIME ;?>" <?php if($manager->getType() == Dao_Manager::TYPE_PARTTIME) {?>selected="selected"<?php }?>>兼职</option>
                            <option value="<?php echo Dao_Manager::TYPE_PARTNER ;?>" <?php if($manager->getType() == Dao_Manager::TYPE_PARTNER) {?>selected="selected"<?php }?>>合作方</option>
                        </select>
                    </div>
                </div>
                <div id="staffIdArea" class="control-group">
                    <label class="control-label">员工号</label>
                    <div class="controls">
                        <input id="staff_id" class="form-control" name="staff_id" type="text" value="<?php echo $manager->getStaffId();?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">电子邮箱</label>
                    <div class="controls">
                        <input id="email" class="form-control" name="email" type="text" value="<?php echo $manager->getEmail();?>" disabled>
                    </div>
                </div>
                <!-- <div class="control-group">
                    <label class="control-label">密码</label>
                    <div class="controls">
                        <input id="password" class="form-control" name="password" type="password">
                    </div>
                </div> -->
                <div class="control-group">
                    <label class="control-label">手机号码</label>
                    <div class="controls">
                        <input id="mobile" class="form-control" name="mobile" type="text" value="<?php echo $manager->getMobile();?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">电话号码</label>
                    <div class="controls">
                        <input id="phone" class="form-control" name="phone" type="text" value="<?php echo $manager->getPhone();?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">角色（*按ctrl多选）</label>
                    <div class="controls">
                        <select id="roleIds" name="roleIds[]" multiple="multiple" size="6" class="form-control">
                            <?php foreach ($roles as $role) {?>
                            <option value="<?php echo $role->getRoleId();?>" <?php foreach($managerRoleMap as $item) {?><?php if ($item['role_id'] == $role->getRoleId()) { echo 'selected="selected"'; }?><?php }?>><?php echo $role->getName();?></option>
                            <?php }?>
                        </select>
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
<script src="/resources/js/module/manager.js"></script> 
<script type="text/javascript">
// Form Validation
$("#validate-form").validate({
    rules:{
        given_name:{
            required:true
        },
        type:{
            required:true
        },
        staff_id:{
            required:{
                depends:function(element) {
                    return $("#type").val() == 0;
                }
            }
        },
        email:{
            required:true,
            email:true
        },
        roleIds:{
            required:true
        },
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