<div id="content">
  <div id="content-header">
    <h1>模块管理
        <div class="pull-right">
            <a class="btn btn-primary" data-link="/module/add" onclick="javascript:Module.List.popup(this,'添加模块');">添加模块</a>
        </div>
    </h1>
  </div>

  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-content nopadding">
            <div class="controls controls-row" style="padding:10px 0">
              <input type="button" value="删除" onclick="Module.List.delete(this);" class="span1 m-wrap btn-danger" style="float:left; margin-left:20px">
            </div>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr class="active">
                        <th>
                          <input type="checkbox" id="title-table-checkbox" onclick="Module.List.checkedAll(this);" name="title-table-checkbox" style="margin:0"/>
                        </th>
                        <th class="w10p">ID</th>
                        <th class="w20p">名称</th>
                        <th class="w20p">模块</th>
                        <th class="w15p">入口文件</th>
                        <th class="w20p">创建时间</th>
                        <th class="text-center">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach($modules as $module) {
                    ?>
                    <tr>
                        <td><input type="checkbox" name="id[]" value="<?php echo $module->getModuleId();?>" style="margin:0"></td>
                        <td class="center"><?php echo $module->getModuleId(); ?></td>
                        <td class="center"><?php echo $module->getName(); ?></td>
                        <td class="center"><?php echo $module->getModule(); ?></td>
                        <td class="center"><?php echo $module->getPortal(); ?></td>
                        <td class="center"><?php echo $module->getCreateTimeString(); ?></td>
                        <td class="text-center">
                        <i class="icon-edit"> </i> <a href="javascript:void(0);" data-link="/module/edit?moduleId=<?php echo $module->getModuleId(); ?>" onclick="Module.List.popup(this, '编辑模块');">修改</a>
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
<script src="/resources/js/jquery.min.js"></script> 
<script src="/resources/js/jquery.ui.custom.js"></script> 
<script src="/resources/js/bootstrap.min.js"></script> 
<script src="/resources/layer/layer.js"></script>
<script src="/resources/js/sweetalert.min.js"></script>
<script src="/resources/js/module/module.js?v=<?php echo Kohana::$config->load('default.jsVersion');?>"></script>