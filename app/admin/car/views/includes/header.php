    <!--Header-part-->
    <div id="header">
      <h1><a href="dashboard.html"><?php echo $adminConfig['display_name'];?>管理后台</a></h1>
    </div>
    <!--close-Header-part--> 

    <!--top-Header-menu-->
    <div id="user-nav" class="navbar navbar-inverse">
        <ul class="nav">
            <li  class="">
                <a>
                    <i class="icon icon-user"></i>&nbsp;
                    <span class="text">欢迎你，<?php echo Manager::givenName();?></span>&nbsp;
                    <b class="caret"></b>
                </a>
            </li>
            <!-- ul class="dropdown-menu">
              <li><a data-link="/manager/profileInfo" onclick="Main.showProfile(this);"><i class="icon-user"></i> 个人资料</a></li>
              <li class="divider"></li>
              <li><a href="/default/logout"><i class="icon-key"></i> 退出系统</a></li>
            </ul -->
            <?php if(isset($adminConfig['login_type']) && $adminConfig['login_type'] == 3) {?>
            <li class=""><a id="logout" title="退出系统"><i class="icon icon-share-alt"></i> <span class="text">&nbsp;退出系统</span></a></li>
            <?php } else {?>
            <li class=""><a id="logout" title="退出系统" href="/default/logout"><i class="icon icon-share-alt"></i> <span class="text">&nbsp;退出系统</span></a></li>
            <?php }?>
        </ul>
    </div>
    <?php if(isset($adminConfig['login_type']) && $adminConfig['login_type'] == 3) {?>
    <script type="text/javascript" src="<?php if(isset($resourcePath) && $resourcePath) echo $resourcePath;?>/resources/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php if(isset($resourcePath) && $resourcePath) echo $resourcePath;?>/resources/skyeye/js/login.js"></script>
    <?php }?>
