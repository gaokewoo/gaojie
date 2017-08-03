<div id="content">
  <div id="content-header" style="height:15px"></div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <table class="table table-bordered table-hover">
            <thead>
                <tr class="active">
                    <th>ID</th>
                    <th>姓名</th>
                    <?php 
                        if ($roleId == $configRoleId) { ?>
                            <th>Uid</th>
                    <?php  } else { ?>
                            <th>邮箱</th>
                    <?php  }
                     ?> 
                    <th>手机</th>
                    <th>电话</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach($managers as $manager) {
                ?>
                <tr>
                    <td><?php echo $manager->getManagerId(); ?></td>
                    <td><?php echo $manager->getGivenName(); ?></td>
                    <td><?php echo $manager->getEmail(); ?></td>
                    <td><?php echo $manager->getMobile(); ?></td>
                    <td><?php echo $manager->getPhones(); ?></td>
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
<script src="/resources/js/jquery.min.js"></script> 
<script src="/resources/js/jquery.ui.custom.js"></script> 
<script src="/resources/js/bootstrap.min.js"></script> 