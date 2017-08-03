<div id="content">
  <div id="content-header">
    <h1>异常日志</h1>
  </div>

  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-content nopadding">
            <div class="controls controls-row" style="padding-top:10px">
              <form action="/log/crash" method="get">
              <input type="submit" value="搜索" class="span1 m-wrap btn-primary" style="float:right;margin-right:10px;">
              <input type="text" name="keyword" value="<?php echo $keyword;?>" placeholder="消息/主机名/IP" class="span3 m-wrap" style="float:right">
              </form>
            </div>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered table-hover">
                <thead>
                   <tr>
                      <th class="w10p">ID</th>
                      <th class="w10p">等级</th>
                      <th class="w55p">错误消息</th>
                      <th class="w10p">Web服务器</th>
                      <th class="w15p">时间</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach($crashLogs as $crashLog) {
                    ?>
                    <tr class="gradeX">
                        <td><?php echo $crashLog->getLogCrashId(); ?></td>
                        <td><?php echo $crashLog->getLevel(); ?></td>
                        <td style="text-align:left"><a href="javascript:void(0);" onclick="Crashlog.collapse(this);"><?php echo substr($crashLog->getMessage(),0,180); ?></a></td>
                        <td><?php echo $crashLog->getIp(); ?></td>
                        <td><?php echo $crashLog->getCreateTimeString(); ?></td> 
                    </tr>
                    <tr class="gradeY" style="display:none;">
                        <td colspan="5" style="text-align:left"><strong><?php echo $crashLog->getTrace();?></strong></td>
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
<script src="/resources/js/module/crashlog.js?v=<?php echo Kohana::$config->load('default.jsVersion');?>"></script>
