<div id="content">
    <div id="content-header" style="height:15px"></div>
		<div class="row-fluid">
			<div class="span14">
				<div class="widget-box">
                    <div class="widget-content nopadding">
                        <!--<form id="form1" name="form1" method="post" action="/car/repair_detail/save">-->
                        <form class="form-horizontal" id="validate-form" role="form" method="post" action="/car/repair_detail/save?repairId=<?php echo $repairId;?>">
                        <table width="1000" align="center" border="1" cellpadding="0" cellspacing="0" id="tabProduct">  
                            <tr>  
                              <td width="32" align="center" bgcolor="#EFEFEF" Name="box"><input type="checkbox" name="checkbox" value="checkbox" /></td>
                              <!--<td width="152" bgcolor="#EFEFEF" Name="ProductName" EditType="DropDownList" DataItems="{text:'A',value:'a'},{text:'B',value:'b'},{text:'C',value:'c'},{text:'D',value:'d'}">商品名称</td>-->
                              <td width="100" bgcolor="#EFEFEF" Name="repairDate" EditType="TextBox">日期</td>
                              <td width="103" bgcolor="#EFEFEF" Name="repairProject" EditType="TextBox">维修项目</td>
                              <td width="103" bgcolor="#EFEFEF" Name="partProject" EditType="TextBox">配价项目</td>
                              <td width="40" bgcolor="#EFEFEF" Name="price" EditType="TextBox">单价</td>
                              <td width="40" bgcolor="#EFEFEF" Name="partNum" EditType="TextBox">数量</td>
                              <td width="40" bgcolor="#EFEFEF" Name="workHour" EditType="TextBox">工时</td>
                              <td width="80" bgcolor="#EFEFEF" Name="supplier" EditType="TextBox">供货商</td>
                              <td width="70" bgcolor="#EFEFEF" Name="warrantyPeriod" EditType="TextBox">保修时长</td>
                              <td width="130" bgcolor="#EFEFEF" Name="gearOilStatus" EditType="DropDownList" DataItems="{text:'是',value:'1'},{text:'否',value:'0'}">齿轮油是否更换</td>
                              <td width="100" bgcolor="#EFEFEF" Name="thisServiceMileage" EditType="TextBox">本次保养里程</td>
                              <td width="100" bgcolor="#EFEFEF" Name="nextServiceMileage" EditType="TextBox">下次保养里程</td>
                              <td width="70" bgcolor="#EFEFEF" Name="payedStatus" EditType="DropDownList" DataItems="{text:'是',value:'1'},{text:'否',value:'0'}">是否记账</td>
                              <td width="40" bgcolor="#EFEFEF" Name="sumMoney" EditType="TextBox">合计</td>
                              <td width="40" bgcolor="#EFEFEF" Name="payed" EditType="TextBox">已付</td>
                              <td width="40" bgcolor="#EFEFEF" Name="unpayed" >未付</td>
                              <td width="50" bgcolor="#EFEFEF" Name="remark" EditType="TextBox">备注</td>
                              <!--<td width="120" bgcolor="#EFEFEF" Name="SumMoney" Expression="Amount*Price" Format="#,###.00">合计</td>-->
                            </tr>
								<?php
									foreach ($repairDetails as $repairDetail) {
								?>
								<tr>
                                    <td align="center" bgcolor="#FFFFFF"><input type="checkbox" name="checkbox2" value="checkbox" /></td>  
									<td bgcolor="#FFFFFF"><?php echo $repairDetail->getRepairDate();?></td>
									<td bgcolor="#FFFFFF"><?php echo $repairDetail->getRepairProject();?></td>
									<td bgcolor="#FFFFFF"><?php echo $repairDetail->getPartProject();?></td>
									<td bgcolor="#FFFFFF"><?php echo $repairDetail->getPrice()/100.0;?></td>
									<td bgcolor="#FFFFFF"><?php echo $repairDetail->getPartNum();?></td>
									<td bgcolor="#FFFFFF"><?php echo $repairDetail->getWorkHour();?></td>
									<td bgcolor="#FFFFFF"><?php echo $repairDetail->getSupplier();?></td>
									<td bgcolor="#FFFFFF"><?php echo $repairDetail->getWarrantyPeriod();?></td>
                                    <td bgcolor="#FFFFFF" Value=<?php echo $repairDetail->getGearOilStatus()?>><?php if($repairDetail->getGearOilStatus()==1){echo '是';}else{echo '否';}?></td>
									<td bgcolor="#FFFFFF"><?php echo $repairDetail->getThisServiceMileage();?></td>
									<td bgcolor="#FFFFFF"><?php echo $repairDetail->getNextServiceMileage();?></td>
                                    <td bgcolor="#FFFFFF" Value=<?php echo $repairDetail->getPayedStatus()?>><?php if($repairDetail->getPayedStatus()==1){echo '是';}else{echo '否';}?></td>
									<td bgcolor="#FFFFFF"><?php echo $repairDetail->getSumMoney()/100.0;?></td>
									<td bgcolor="#FFFFFF"><?php echo $repairDetail->getPayed()/100.0;?></td>
									<td bgcolor="#FFD306"><?php echo ($repairDetail->getSumMoney()-$repairDetail->getPayed())/100.0;?></td>
									<td bgcolor="#FFFFFF"><?php echo $repairDetail->getRemark();?></td>
								</tr>
								<?php	
								}
								?>
                        </table>  
                        <br />  
                        <table align="center" border="0" cellpadding="0" cellspacing="0">  
                            <tr> 
                                <td> 
                                     <input type="button" name="Submit" value="新增" class="btn btn-primary" onclick="AddRow(document.getElementById('tabProduct'),1)" />  
                                     <input type="button" name="Submit2" value="删除" class="btn btn-primary" onclick="DeleteRow(document.getElementById('tabProduct'),1)" />  
                                     <input type="button" name="Submit22" value="重置" class="btn btn-primary" onclick="window.location.reload()" />  
                                     <input type="submit" name="Submit3" value="提交" class="btn btn-primary" />  
                               </td> 
						   </tr>
                        </table>  
                        </form>  
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<style type="text/css">
<!--
body,div,p,ul,li,font,span,td,th{
font-size:10pt;
line-height:155%;
}
table{
border-top-width: 1px;
border-right-width: 1px;
border-bottom-width: 0px;
border-left-width: 1px;
border-top-style: solid;
border-right-style: solid;
border-bottom-style: none;
border-left-style: solid;
border-top-color: #CCCCCC;
border-right-color: #CCCCCC;
border-bottom-color: #CCCCCC;
border-left-color: #CCCCCC;
}
td{
border-bottom-width: 1px;
border-bottom-style: solid;
border-bottom-color: #CCCCCC;
}
.EditCell_TextBox {
width: 90%;
border:1px solid #0099CC;
}
.EditCell_DropDownList {
width: 90%;
}
-->
</style>
<script src="/resources/js/jquery.min.js"></script> 
<script src="/resources/js/jquery.ui.custom.js"></script> 
<script src="/resources/js/bootstrap.min.js"></script> 
<script src="/resources/js/jquery.validate.js"></script> 
<script src="/resources/layer/layer.js"></script>
<script src="/resources/js/sweetalert.min.js"></script>
<script src="/resources/js/module/manager.js"></script> 
<script src="/resources/js/edit-tables.js"></script> 
<script type="text/javascript">
    var tabProduct = document.getElementById("tabProduct");  
    // 设置表格可编辑  
    // 可一次设置多个，例如：EditTables(tb1,tb2,tb2,......)  
    EditTables(tabProduct);  

$("#validate-form").validate({
    rules:{},
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
        console.log(JSON.stringify(GetTableData(document.getElementById('tabProduct'))));
        $.ajax({
            url: $(form).attr('action'),
            type: "POST",
            data: JSON.stringify(GetTableData(document.getElementById('tabProduct'))),
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
                        window.location.reload();
                        //var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                        //parent.layer.close(index); //再执行关闭  
                        //parent.location.href = data.redirect;
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
