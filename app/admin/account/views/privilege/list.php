<div id="content">
  <div id="content-header">
    <h1>权限管理
      <div class="pull-right">
        <a class="btn btn-primary" data-link="/privilege/add" onclick="Privilege.List.popup(this, '添加权限');">添加权限</a>
      </div>
    </h1>
  </div>

  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <?php
        foreach ($menus as $menu) {
        ?>
        <div class="widget-box">
          <div class="widget-title">
            <div class="checkbox privilege-menu-1">
              <label>
                <strong><?php echo $menu->getName();?></strong> &nbsp;&nbsp;
                <a href="javascript:void(0);" data-link="/privilege/edit?privilegeId=<?php echo $menu->getPrivilegeId();?>" onclick="Privilege.List.popup(this, '编辑权限');"><i class="icon-edit"> </i></a> 
                <a href="javascript:void(0);" data-id="<?php echo $menu->getPrivilegeId();?>" onclick="Privilege.List.delete(this);"><i class="icon-remove"> </i></a>
              </label>
            </div>
          </div>
          <div class="widget-content">
            <div class="row-fluid">
              <div class="span12 privilege-controller">
                <ul>
                  <?php
                  foreach ($controllers as $controller) {
                    if ($controller->getParentId() == $menu->getPrivilegeId()) {
                  ?>
                  <li>
                    <div class="controls">
                      <div class="checkbox controller-left" style="padding-left:0"><?php echo $controller->getName();?></div>
                      <div class="controller-right">
                        <a href="javascript:void(0);" data-link="/privilege/edit?privilegeId=<?php echo $controller->getPrivilegeId();?>" onclick="Privilege.List.popup(this, '编辑权限');"><i class="icon-edit"> </i></a> 
                        <a href="javascript:void(0);" data-id="<?php echo $controller->getPrivilegeId();?>" onclick="Privilege.List.delete(this);"><i class="icon-remove"> </i></a>
                      </div>
                    </div>
                  </li>
                  <?php
                    }
                  }
                  ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <?php
        }
        ?>
      </div>
    </div>
  </div>
</div>
<link rel="stylesheet" href="/resources/css/privilege.css" />
<script src="/resources/js/jquery.min.js"></script> 
<script src="/resources/js/jquery.ui.custom.js"></script> 
<script src="/resources/js/bootstrap.min.js"></script> 
<script src="/resources/layer/layer.js"></script>
<script src="/resources/js/sweetalert.min.js"></script>
<script src="/resources/js/module/privilege.js?v=<?php echo Kohana::$config->load('default.jsVersion');?>"></script>
