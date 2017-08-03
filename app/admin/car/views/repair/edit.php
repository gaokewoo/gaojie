<div id="content">
  <div id="content-header" style="height:15px"></div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-content nopadding">
            <form enctype="multipart/form-data" class="form-horizontal" id="validate-form" role="form" method="post" action="/car/repair/modify?repairId=<?php echo $repairId;?>">
                <div class="control-group">
                    <label class="control-label">单位名称</label>
                    <div class="controls">
                        <input class="form-control" name="company_name" type="text" style="width:30%" id="company_name" value="<?php echo $repair->getCompanyName();?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">姓名</label>
                    <div class="controls">
                        <input class="form-control" name="people_name" type="text" style="width:30%" id="people_name" value="<?php echo $repair->getPeopleName();?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">电话</label>
                    <div class="controls">
                        <input class="form-control" name="phone_no" type="text" style="width:30%" id="phone_no" value="<?php echo $repair->getPhoneNo();?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">车型</label>
                    <div class="controls">
                        <input class="form-control" name="car_type" type="text" style="width:30%" id="car_type" value="<?php echo $repair->getCarType();?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">车牌</label>
                    <div class="controls">
                        <input class="form-control" name="plate_no" type="text" style="width:30%" id="plate_no" value="<?php echo $repair->getPlateNo();?>">
                    </div>
                </div>
               <!--
                <div class="control-group">
                    <div class="controls">
                      <?php
                      if($repair->getStatus()==0)
                      {
                      ?>
                          <label class="radio-inline">
                            <input type="radio"  value="0" name="status" checked>未结清
                          </label>
                          <label class="radio-inline">
                            <input type="radio"  value="1" name="status">已结清
                          </label>
                      <?php
                      }
                      else
                      {
                      ?>
                          <label class="radio-inline">
                            <input type="radio"  value="0" name="status">未结清
                          </label>
                          <label class="radio-inline">
                            <input type="radio"  value="1" name="status" checked>已结清
                          </label>
                      <?php
                      }
                      ?>
                    </div>
                </div>
                -->
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
        company_name:{
            required:false
        },
        people_name:{
            required:true
        },
        phone_no:{
            required:false
        },
        car_type:{
            required:false
        },
        plate_no:{
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
