<!--Header-part-->
<div id="header">
  <h1>
    <a href="/main">
      <span style="font-style:oblique;color: white"><?php echo $adminConfig['display_name'];?>管理系统</span>
    </a>
  </h1>
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
        <li class=""><a id="logout" title="退出系统" href="/default/logout"><i class="icon icon-share-alt"></i> <span class="text">&nbsp;退出系统</span></a></li>
    </ul>
</div>
