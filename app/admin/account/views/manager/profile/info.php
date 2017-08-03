<div id="content">
  <div id="content-header" style="height:15px">
    
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-content">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <th class="col-lg-2 text-center">姓名</th>
                  <td><?php echo $manager->getGivenName();?></td>
                </tr>
                <tr>
                  <th class="col-lg-2 text-center">员工类型</th>
                  <td><?php 
                  if($manager->getType() == Dao_Manager::TYPE_FULLTIME){
                    echo '正式员工';
                  } elseif($manager->getType() == Dao_Manager::TYPE_INTERN) {
                    echo '实习生';
                  } elseif($manager->getType() == Dao_Manager::TYPE_PARTTIME) {
                    echo '兼职';
                  } elseif($manager->getType() == Dao_Manager::TYPE_PARTNER) {
                    echo '合作方';
                  }
                  ?></td>
                </tr>
                <tr>
                  <th class="col-lg-2 text-center">员工号</th>
                  <td><?php echo $manager->getStaffId();?></td>
                </tr>
                <tr>
                  <th class="col-lg-2 text-center">电子邮箱</th>
                  <td><?php echo $manager->getEmail();?></td>
                </tr>
                <tr>
                  <th class="col-lg-2 text-center">手机号码</th>
                  <td><?php echo $manager->getMobile();?></td>
                </tr>
                <tr>
                  <th class="col-lg-2 text-center">电话号码</th>
                  <td><?php echo $manager->getPhone();?></td>
                </tr>
                <tr>
                  <th class="col-lg-2 text-center">角色</th>
                  <td>
                    <?php
                    $roleNames = array();
                    foreach ($managerRoleMap as $item) {
                      foreach($roles as $role) {
                        if($role->getRoleId() == $item['role_id']) {
                          $roleNames[] = $role->getName();
                        }
                      }
                    }
                    echo implode(',', $roleNames);
                    ?>
                  </td>
                </tr>
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