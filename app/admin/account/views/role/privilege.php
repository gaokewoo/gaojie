<div id="content">
  <div id="content-header" style="height:15px"></div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <input type="hidden" name="roleId" value="<?php echo $roleId;?>" />
        <?php
        foreach ($menus as $menu) {
        ?>
        <div class="widget-box">
          <div class="widget-title">
            <div class="checkbox privilege-menu">
              <label>
                <input name="privilege_id[]" type="checkbox" data-type="menu" value="<?php echo $menu->getPrivilegeId();?>" onclick="Privilege.List.assign(this);" <?php if(in_array($menu->getPrivilegeId(), $privileges)) {?>checked<?php }?>> <strong><?php echo $menu->getName();?></strong>
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
                    <div class="checkbox">
                      <label>
                        <input name="privilege_id[]" type="checkbox" data-type="controller" value="<?php echo $controller->getPrivilegeId();?>" onclick="Privilege.List.assign(this);" <?php if(in_array($controller->getPrivilegeId(), $privileges)) {?>checked<?php }?>> <?php echo $controller->getName();?>
                      </label>
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
<script src="/resources/js/module/privilege.js?v=<?php echo Kohana::$config->load('default.jsVersion');?>"></script>