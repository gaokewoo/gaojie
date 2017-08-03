<?php 
  $privileges = Manager::privileges();
  $menus = array();
  $controllers = array();
  foreach ($privileges as $privilege) {
    if ($privilege->getType() == Model_Privilege::TYPE_MENU && $privilege->getIsDisplay() == Model_Privilege::IS_DISPLAY) {
      $menus[] = $privilege;
    }
    if ($privilege->getType() == Model_Privilege::TYPE_CONTROLLER && $privilege->getIsDisplay() == Model_Privilege::IS_DISPLAY) {
      $controllers[] = $privilege;
    }
  }
?>
<!--sidebar-menu-->
<div id="sidebar" >
  <ul>
    <li class="submenu active">
      <a class="menu_a" link="/dashboard"><i class="home-icon"></i> <span>首页</span></a> 
    </li>
    <?php 
      foreach ($menus as $menu) {
        $count = 0;
        foreach ($controllers as $controller) {
          if ($controller->getParentId() == $menu->getPrivilegeId()) {
            $count++;
          }
        }
    ?>
    <li class="submenu"> 
      <a href="#">
      <?php if($menu->getIcon()) {?>
        <i class="<?php echo $menu->getIcon();?>"></i> 
      <?php } else {?>
        <i class="icon icon-table"></i> 
      <?php }?>
        <span><?php echo $menu->getName();?></span> 
      </a>
      <ul>
      <?php
        foreach ($controllers as $controller) {
          if ($controller->getParentId() == $menu->getPrivilegeId()) {
      ?>
        <li><a class="menu_a" link="<?php echo Valid::not_empty($controller->getModule()) ? '/'.$controller->getModule() : '';?>/<?php echo $controller->getController();?>/<?php echo $controller->getAction();?>"><i class="icon icon-caret-right"></i><?php echo $controller->getName();?></a></li>
      <?php }
        }
      ?>
      </ul>
    </li>
    <?php }?>
  </ul>
</div>
<!--sidebar-menu-->