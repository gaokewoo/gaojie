<div id="content">
	<div id="content-header">
		<h1>维修记录</h1>
	</div>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
					<div class="widget-content nopadding">
						<div class="controls controls-row" style="padding-top:10px">
							<a style="position: absolute;top: 10px;" class="btn btn-primary" data-link="/car/repair/add" onclick="Repair.List.popup(this, '添加记录');">+ 添加记录</a>
							<form action="/car/repair/list" method="get">
								<input type="submit" value="搜索" name="" class="span1 m-wrap btn-primary" style="float:right;margin-right:10px;">
								<input type="text" name="keyword" value="<?php echo $keyword;?>" placeholder="车牌/姓名" class="span3 m-wrap" style="float: right">
							</form>
						</div>
					</div>
					<div class="widget-content nopadding">
						<table class="table table-bordered table-hover" style="table-layout:fixed;">
							<thead>
								<tr class="active">
									<th class="w15p">日期</th>
									<th class="w13p">姓名</th>
									<th class="w15p">电话</th>
									<th class="w20p">单位</th>
									<th class="w25p">车型</th>
									<th class="w20p">车牌</th>
									<th class="w15p">合计金额</th>
									<th class="w25p">操作</th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach ($repairs as $repair) {
								?>
								<tr>
									<td class="center"><?php echo date('Y-m-d', $repair->getCreateTime());?></td>
									<td class="center"><?php echo $repair->getPeopleName();?></td>
									<td class="center"><?php echo $repair->getPhoneNo();?></td>
									<td class="center"><?php echo $repair->getCompanyName();?></td>
									<td class="center"><?php echo $repair->getCarType();?></td>
									<td class="center"><?php echo $repair->getPlateNo();?></td>
									<td class="center"><?php echo $repair->getTotalMoney();?></td>
									<td class="text-center">
										<a href="javascript:void(0);" data-link="/car/repair/edit?repairId=<?php echo $repair->getRepairId();?>" onclick="Repair.List.popup(this, '编辑维修记录')">修改</a>
										&nbsp;&nbsp;&nbsp;
										<a href="javascript:void(0);" value="" onclick="Repair.List.delete('<?php echo $repair->getRepairId();?>')">删除</a>
										&nbsp;&nbsp;&nbsp;
										<a href="javascript:void(0);" data-link="/car/repair_detail/list?repairId=<?php echo $repair->getRepairId();?>" onclick="Repair.List.popup(this, '维修记录详情')">详情</a>
									</td>
								</tr>
								<?php	
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?php if(isset($resourcePath) && $resourcePath) echo $resourcePath;?>/resources/js/jquery.min.js"></script>
<script src="<?php if(isset($resourcePath) && $resourcePath) echo $resourcePath;?>/resources/js/jquery.ui.custom.js"></script>
<script src="<?php if(isset($resourcePath) && $resourcePath) echo $resourcePath;?>/resources/js/bootstrap.min.js"></script>
<script src="<?php if(isset($resourcePath) && $resourcePath) echo $resourcePath;?>/resources/layer/layer.js"></script>
<script src="<?php if(isset($resourcePath) && $resourcePath) echo $resourcePath;?>/resources/js/sweetalert.min.js"></script>
<script src="<?php if(isset($resourcePath) && $resourcePath) echo $resourcePath;?>/resources/js/module/car/repair.js?v=<?php echo Kohana::$config->load('default.jsVersion');?>"></script>
