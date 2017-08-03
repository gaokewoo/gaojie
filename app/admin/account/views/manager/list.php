<div id="content">
  <div id="content-header">
    <h1>管理员管理
        <div class="pull-right">
            <a class="btn btn-primary" data-link="/manager/add" onclick="Manager.List.popup(this, '添加管理员');">添加管理员</a>
        </div>
    </h1>
  </div>

  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-content nopadding">
            <div class="controls controls-row" style="padding-top:10px">
              <input type="button" value="启用" onclick="Manager.List.enable(this);" class="span1 m-wrap btn-primary" style="float:left; margin-left:20px">
              <input type="button" value="禁用" onclick="Manager.List.disable(this);" class="span1 m-wrap btn-danger" style="float:left; margin-left:0">
              <form action="/manager/list" method="get">
              <input type="submit" value="搜索" class="span1 m-wrap btn-primary" style="float:right;margin-right:10px;">
              <input type="text" name="keyword" value="<?php echo $keyword;?>" placeholder="ID/姓名/邮箱/手机号" class="span3 m-wrap" style="float:right">
              </form>
            </div>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered table-striped with-check">
                <thead>
                    <tr class="active">
                        <th>
                          <input type="checkbox" id="title-table-checkbox" onclick="Manager.List.checkedAll(this);" name="title-table-checkbox" style="margin:0"/>
                        </th>
                        <th class="w10p">ID</th>
                        <th class="w12p">姓名</th>
                        <th class="w20p">邮箱</th>
                        <th>角色</th>
                        <th class="w12p">手机</th>
                        <th class="w8p">状态</th>
                        <th class="text-center">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach($managers as $manager) {
                    ?>
                    <tr>
                      <td><input type="checkbox" name="id[]" value="<?php echo $manager->getManagerId();?>" style="margin:0"></td>
                      <td class="center"><?php echo $manager->getManagerId(); ?></td>
                      <td class="center"><?php echo $manager->getGivenName(); ?></td>
                      <td class="center"><?php echo $manager->getEmail(); ?></td>
                      <td class="center"><?php echo $manager->getRoles(); ?></td>
                      <td class="center"><?php echo $manager->getMobile(); ?></td>
                      <td class="center"><?php echo $manager->getStatusString(); ?></td>
                      <td class="text-center">
                      <?php if ($manager->getStatus() == Dao_Manager::STATUS_NORMAL) { ?>
                      <i class="icon-edit"> </i> <a href="javascript:void(0);" data-link="/manager/edit?managerId=<?php echo $manager->getManagerId(); ?>" onclick="Manager.List.popup(this, '编辑用户');">修改</a> 
                      <?php } ?>
                      </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
          </div>
          <?php echo $pagination; ?>
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
<script src="/resources/js/module/manager.js?v=<?php echo Kohana::$config->load('default.jsVersion');?>"></script>