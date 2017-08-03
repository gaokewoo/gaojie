<div id="content">
  <div id="content-header">
    <h1>角色管理
        <div class="pull-right">
            <a class="btn btn-primary" data-link="/role/add" onclick="Role.List.popup(this, '添加角色');">添加角色</a>
        </div>
    </h1>
  </div>

  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-content nopadding">
            <div class="controls controls-row" style="padding:10px 0">
              <input type="button" value="删除" onclick="Role.List.delete(this);" class="span1 m-wrap btn-danger" style="float:left; margin-left:20px">
            </div>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered table-striped with-check">
                <thead>
                    <tr class="active">
                        <th>
                          <input type="checkbox" id="title-table-checkbox" onclick="Role.List.checkedAll(this);" name="title-table-checkbox" style="margin:0"/>
                        </th>
                        <th class="w10p">角色ID</th>
                        <th class="w20p">角色名称</th>
                        <th class="w20p">创建时间</th>
                        <th class="text-center">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach($roles as $role) {
                    ?>
                    <tr>
                        <td><input type="checkbox" name="id[]" value="<?php echo $role->getRoleId();?>" style="margin:0"></td>
                        <td class="center"><?php echo $role->getRoleId(); ?></td>
                        <td class="center"><?php echo $role->getName(); ?></td>
                        <td class="center"><?php echo $role->getCreateTimeString(); ?></td>
                        <td class="text-center">
                        <i class="icon-edit"> </i> <a href="javascript:void(0);" data-link="/role/edit?roleId=<?php echo $role->getRoleId(); ?>" onclick="Role.List.popup(this, '编辑角色');">修改</a> 
                        <i class="icon-reorder"> </i> <a href="javascript:void(0);" data-link="/role/privileges?roleId=<?php echo $role->getRoleId(); ?>" onclick="Role.List.popup(this, '权限列表');">权限</a> 
                        <i class="icon-cogs"> </i> <a href="javascript:void(0);" data-link="/role/members?roleId=<?php echo $role->getRoleId(); ?>" onclick="Role.List.popup(this, '成员列表');">成员</a>
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
<script src="/resources/js/module/role.js?v=<?php echo Kohana::$config->load('default.jsVersion');?>"></script>
